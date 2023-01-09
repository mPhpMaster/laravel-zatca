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
                       ->setVatId('311111111111113')
                       ->setInvoiceDate('2023-11-24T03:48:00Z')
                       ->setInvoiceTotalAmount('100')
                       ->setVatAmount('15')
                       ->toBase64();

        $this->assertEquals('AQxDb21wYW55IG5hbWUCDzMxMTExMTExMTExMTExMwMUMjAyMy0xMS0yNFQwMzo0ODowMFoEAzEwMAUCMTU=', $value);
    }

    /** @test */
    public function shouldGenerateAQrCodeAsArabic()
    {
        $value = TagBag::make()
                       ->setCompany('المنشآة')
                       ->setVatId('311111111111113')
                       ->setInvoiceDate('2023-11-24T03:48:00Z')
                       ->setInvoiceTotalAmount('100')
                       ->setVatAmount('15')
                       ->toTLV();

        $this->assertEquals(
            'AQ7Yp9mE2YXZhti02KLYqQIPMzExMTExMTExMTExMTEzAxQyMDIzLTExLTI0VDAzOjQ4OjAwWgQDMTAwBQIxNQ==',
            base64_encode($value)
        );
    }

    /** @test */
    public function shouldGenerateAQrCodeFromTagsClasses()
    {
        $generatedString = TagBag::make()
                                 ->tag(Company::TAG, Company::make('Company name'))
                                 ->tag(VatId::TAG, VatId::make('311111111111113'))
                                 ->tag(InvoiceDate::TAG, InvoiceDate::make('2023-11-24T03:48:00Z'))
                                 ->tag(InvoiceTotalAmount::TAG, InvoiceTotalAmount::make('100'))
                                 ->tag(VatAmount::TAG, VatAmount::make('15'))
                                 ->toBase64();

        $this->assertEquals(
            'AQxDb21wYW55IG5hbWUCDzMxMTExMTExMTExMTExMwMUMjAyMy0xMS0yNFQwMzo0ODowMFoEAzEwMAUCMTU=',
            $generatedString
        );
    }

    /** @test */
    public function shouldGenerateAQrCodeDisplayAsImageData()
    {
        $value = TagBag::make()
                       ->setCompany('المنشآة')
                       ->setVatId('311111111111113')
                       ->setInvoiceDate('2023-11-24T03:48:00Z')
                       ->setInvoiceTotalAmount('100')
                       ->setVatAmount('15')
                       ->toImage();

        $this->assertEquals(
            'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOEAAADhCAIAAACx0UUtAAAABnRSTlMA/wD/AP83WBt9AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAFaElEQVR4nO3dwW7zNhCF0ab43/+V001XWqhgOZS+xOdsY0tyfEF4QHL49f39/ReE/f32A8B/kFHqZJQ6GaVORqmTUepklDoZpU5GqZNR6mSUOhmlTkapk1HqZJQ6GaVORqmTUepklLo/O2/++vqaeo57l01Xl/vu/HXpvhf3l1p6qiU7H3Dnv7Fj5/MaR6mTUepklDoZpW6rZroYbCcx+MN/6VJLT3Wu/ri/0f0z73wLj32DS4yj1MkodTJKnYxSN1kzXQzO6Jy78mBFtXTle4NzYzvzW+e+wSXGUepklDoZpU5GqTtYMzWdm8HaKc6WLvXW+rq3GEepk1HqZJQ6GaXuN9RMO8XK0pXPFUlLf7349SWUcZQ6GaVORqmTUeoO1kznFmuda82wUxUNft6lh7x/7+BjvMU4Sp2MUiej1MkodZM102MzHIMr2R7bOfTYfS8G58beYhylTkapk1HqZJS6rZrprXmIx2awBsuRwfsOiswk3TOOUiej1MkodTJK3WvnM+0se3ur+cLFY4XO4I3OTTudO4/KOEqdjFIno9TJKHWT80yD+2wGq4TIFM5g3+5z27l2Xnxud5dxlDoZpU5GqZNR6l6bZ9q51GOtuB/rAfFYRTXosWLUOEqdjFIno9TJKHVfgz+xBxfUnXuMc1cePD32F5zDO8g4Sp2MUiej1MkodQd7jS/9AI/03BvsNb7TKG+w/FoyuL3JfiY+iIxSJ6PUySh1kzXT4LzL4GTJYMeEwRcPFliDCwj1Gof/Q0apk1HqZJS6g2vzlkTmeyIzOks3emsx3j09IPggMkqdjFIno9Rt1UyD57ReDBZJO1deeu/SpZau/Nhc0bnyy9o8fjMZpU5GqZNR6iq9xu8X1J07LjbSMSEy3/NYn44lxlHqZJQ6GaVORqmb7DX+WKe4nWbbg9uqztU95852emx3l7V5fBAZpU5GqZNR6ibX5l28tWXnra4H5z5vpEPEPWvz+FwySp2MUiej1L22nylSFpzb/HRv8DHOeWwe8Z5xlDoZpU5GqZNR6ip98+6dmyx5rGHE4IuXDDYkHLzyEuModTJKnYxSJ6PUvVYznZs7eWu92eD5TPcvvhjsXniup/sO4yh1MkqdjFIno9RN9oC4N7jO7UfUWzvNJpa6CJ5rKrjz4kHGUepklDoZpU5GqZvsNX5vsPfd0pXPdYo7d6jSuS6Cj/XNG2QcpU5GqZNR6mSUuuf65j121upbLfiWvNUg47EtSnpA8EFklDoZpU5GqTs4z/RYWbBjadnbuQWE5+rLc3XtuRWDF8ZR6mSUOhmlTkapO9gDYnBy6GKwF9y5RgafNkd1/94dxlHqZJQ6GaVORqmrnM+0c997kRNgIyvoztU9zrTlc8kodTJKnYxSNznPtHbjH/jj/dxk2FuzQTv0God/ySh1MkqdjFL3Ws2046364yeelrt03/vHeCsqxlHqZJQ6GaVORqk72Ddv0LlDXQdrlyXnrnx/o0hHviXGUepklDoZpU5Gqdvqm3fxWJuDpfeem5XZKUfemme6v9Qga/P4IDJKnYxSJ6PUvdYD4uKxRXFLj3F/5bfayn3a9ibjKHUySp2MUiej1E3OMz3m3HK7nQOK7h/jXO1y/3nfOulqkHGUOhmlTkapk1HqfmTNdPHWWrXISbv377147BjiQcZR6mSUOhmlTkapO1gzRTryPbZl51JD7JQU51Y5Lnlrmd+FcZQ6GaVORqmTUep+ZN+8wd1Ov6Bvd+S/cc9+Jn4zGaVORqmTUep+5PlMfBTjKHUySp2MUiej1MkodTJKnYxSJ6PUySh1MkqdjFIno9TJKHUySp2MUiej1MkodTJKnYxS9w8nBL7GAegArgAAAABJRU5ErkJggg==',
            $value
        );
    }
}
