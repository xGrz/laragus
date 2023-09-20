<?php

namespace xGrz\LaraGus\Services;


use GusApi\Exception\InvalidUserKeyException;
use GusApi\Exception\NotFoundException;
use GusApi\GusApi;
use Illuminate\Support\Collection;
use xGrz\LaraGus\Exceptions\DataNotFoundException;
use xGrz\LaraGus\Exceptions\InvalidApiKeyException;
use xGrz\LaraGus\Exceptions\InvalidVatIdNumberException;
use xGrz\LaraGus\ValueObject\CompanyData;

//Usage:  GusService::nip('XXX-XXX-XX-Xx')->asCollection()
//Usage:  GusService::nip('XXXXXXXXXX')->toArray()

class GusService
{
    private int $vat_id;
    private GusApi $gus;
    private Collection $data;

    /**
     * @throws DataNotFoundException
     * @throws InvalidApiKeyException
     * @throws InvalidVatIdNumberException
     */
    private function __construct(string|int $vat_id)
    {
        self::setVatId($vat_id);
        $this->data = new Collection();
        $this->gus = new GusApi(env('GUS_API_KEY'));
        self::fetch();
    }

    /**
     * @throws DataNotFoundException
     * @throws InvalidApiKeyException
     */
    private function fetch(): void
    {
        try {
            $this->gus->login();
            $reports = $this->gus->getByNip($this->vat_id);

            foreach($reports as $report) {
                $this->data->push(CompanyData::fromGusSearch($report));
            }
        } catch (InvalidUserKeyException $e) {
            throw new InvalidApiKeyException('Invalid api key.');
        } catch (NotFoundException $e) {
            if ($e->getCode() === 0) {
                throw new DataNotFoundException($e->getMessage());
            }
        }
    }

    /**
     * @throws InvalidVatIdNumberException
     */
    private function setVatId(string|int $vat_id): void
    {
        $this->vat_id = preg_replace('/[^0-9]/', '', $vat_id);
        $testNip = strval($this->vat_id);
        if (strlen($testNip) != 10) {
            throw new InvalidVatIdNumberException('VAT id number must consist of 10 digits.');
        }
    }


    /**
     * @throws DataNotFoundException
     * @throws InvalidVatIdNumberException
     * @throws InvalidApiKeyException
     */
    public static function vat_id(string|int $vat_id): static
    {
        return new static($vat_id);
    }

    public function toCollection(): Collection
    {
        return $this->data;
    }

    public function toArray(): array
    {
        return $this
            ->data
            ->map(function ($address) {
                return get_object_vars($address);
            })
            ->toArray();
    }

    public function __destruct()
    {
        if ($this->gus->isLogged()) {
            $this->gus->logout();
        }
    }
}
