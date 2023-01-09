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

    public function setCompany(string $value): self
    {
        return $this->tag(Company::TAG, Company::make($value));
    }

    public function tag(int $tag, Tag $tag_instance): self
    {
        $this->data[ $tag ] = $tag_instance;
        return $this;
    }

    /**
     * @throws \Exception
     */
    public function setVatId(string $value): self
    {
        if( strlen($value) !== 15 ) {
            throw new \Exception("VatId length should be equal to 15");
        }

        return $this->tag(VatId::TAG, VatId::make($value));
    }

    public function setInvoiceDate(string $value): self
    {
        return $this->tag(InvoiceDate::TAG, InvoiceDate::make($value));
    }

    public function setInvoiceTotalAmount(string $value): self
    {
        return $this->tag(InvoiceTotalAmount::TAG, InvoiceTotalAmount::make($value));
    }

    public function setVatAmount(string $value): self
    {
        return $this->tag(VatAmount::TAG, VatAmount::make($value));
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
        return implode('', array_map(fn($tag) => (string) $tag, $this->getData()));
    }

    public function getData(): array
    {
        return $this->data;
    }
}
