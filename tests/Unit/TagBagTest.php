<?php

namespace MPhpMaster\ZATCA\Test\Unit;

use MPhpMaster\ZATCA\TagBag;
use MPhpMaster\ZATCA\Tags\Company;
use MPhpMaster\ZATCA\Tags\InvoiceDate;
use MPhpMaster\ZATCA\Tags\InvoiceTotalAmount;
use MPhpMaster\ZATCA\Tags\VatAmount;
use MPhpMaster\ZATCA\Tags\VatId;
use MPhpMaster\ZATCA\Test\TestCase;

class TagBagTest extends TestCase
{
    /** @test */
    public function shouldGenerateAQrCode()
    {
        $value = TagBag::make()
                       ->setCompany('Company name')
                       ->setVatId('1234567891')
                       ->setInvoiceDate('2021-11-24T03:48:00Z')
                       ->setInvoiceTotalAmount('100')
                       ->setVatAmount('15')
                       ->toBase64();

        $this->assertEquals('AQxDb21wYW55IG5hbWUCCjEyMzQ1Njc4OTEDFDIwMjEtMTEtMjRUMDM6NDg6MDBaBAMxMDAFAjE1', $value);
    }

    /** @test */
    public function shouldGenerateAQrCodeAsArabic()
    {
        $value = TagBag::make()
                       ->setCompany('المنشآة')
                       ->setVatId('1234567891')
                       ->setInvoiceDate('2021-11-24T03:48:00Z')
                       ->setInvoiceTotalAmount('100')
                       ->setVatAmount('15')
                       ->toTLV();

        $this->assertEquals(
            'AQ7Yp9mE2YXZhti02KLYqQIKMTIzNDU2Nzg5MQMUMjAyMS0xMS0yNFQwMzo0ODowMFoEAzEwMAUCMTU=',
            base64_encode($value)
        );
    }

    /** @test */
    public function shouldGenerateAQrCodeFromTagsClasses()
    {
        $generatedString = TagBag::make()
                                 ->tag(Company::TAG, 'Company name')
                                 ->tag(VatId::TAG, '1234567891')
                                 ->tag(InvoiceDate::TAG, '2021-11-24T03:48:00Z')
                                 ->tag(InvoiceTotalAmount::TAG, '100')
                                 ->tag(VatAmount::TAG, '15')
                                 ->toBase64();

        $this->assertEquals(
            'AQxDb21wYW55IG5hbWUCCjEyMzQ1Njc4OTEDFDIwMjEtMTEtMjRUMDM6NDg6MDBaBAMxMDAFAjE1',
            $generatedString
        );
    }

    /** @test */
    public function shouldGenerateAQrCodeDisplayAsImageData()
    {
        $value = TagBag::make()
                       ->setCompany('المنشآة')
                       ->setVatId('1234567891')
                       ->setInvoiceDate('2021-11-24T03:48:00Z')
                       ->setInvoiceTotalAmount('100')
                       ->setVatAmount('15')
                       ->toImage();

        $this->assertEquals(
            'data:image/png;base64,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',
            $value
        );
    }
}
