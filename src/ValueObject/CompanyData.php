<?php

declare(strict_types=1);

namespace xGrz\LaraGus\ValueObject;

use GusApi\SearchReport;

class CompanyData
{
    private function __construct(
        public string|null     $company_name,
        public string|null     $city,
        public int|string|null $post_code,
        public string|null     $street,
        public int|string|null $property_number,
        public int|string|null $apartment_number = null,
        public int|string|null $vat_id = null,
    )
    {
    }

    public static function fromGusSearch(SearchReport $report): CompanyData
    {
        return new CompanyData(
            $report->getName(),
            $report->getCity(),
            $report->getZipCode(),
            $report->getStreet() ?? $report->getCity(),
            $report->getPropertyNumber(),
            $report->getApartmentNumber(),
            $report->getNip(),
        );
    }

    public function toArray(): array
    {
        $this->street = empty($this->street) ? $this->city : $this->street; // fill street if not present
        return get_object_vars($this);
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

}
