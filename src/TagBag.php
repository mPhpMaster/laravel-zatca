<?php

namespace MPhpMaster\ZATCA;

use chillerlan\QRCode\QRCode;
use MPhpMaster\ZATCA\Tags\Company;
use MPhpMaster\ZATCA\Tags\InvoiceDate;
use MPhpMaster\ZATCA\Tags\InvoiceTotalAmount;
use MPhpMaster\ZATCA\Tags\VatAmount;
use MPhpMaster\ZATCA\Tags\VatId;

class TagBag
{
    /**
     * @var Tag|Tag[] $data List of tags
     */
    protected array $data = [];

    public static function make(): self
    {
        return new static(...func_get_args());
    }

    public function addTag(int $tag, string $value): self
    {
        $this->data[] = Tag::make($tag, $value);
        return $this;
    }

    public function addCompany(string $value): self
    {
        $this->data[] = Company::make($value);
        return $this;
    }

    public function addVatId(string $value): self
    {
        $this->data[] = VatId::make($value);
        return $this;
    }

    public function addInvoiceDate(string $value): self
    {
        $this->data[] = InvoiceDate::make($value);
        return $this;
    }

    public function addInvoiceTotalAmount(string $value): self
    {
        $this->data[] = InvoiceTotalAmount::make($value);
        return $this;
    }

    public function addVatAmount(string $value): self
    {
        $this->data[] = VatAmount::make($value);
        return $this;
    }

    public function data(): array
    {
        return $this->data;
    }

    public function toImage(): string
    {
        return (new QRCode)->render($this->toBase64());
    }

    public function toBase64(): string
    {
        return base64_encode($this->toTLV());
    }

    public function toTLV(): string
    {
        return implode('', array_map(fn($tag) => (string)$tag, $this->data));
    }
}
