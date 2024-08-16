<?php

declare(strict_types=1);

namespace Api\Home;

use App\Enum\Language;
use App\Tests\Integration\AbstractTestCase;
use Symfony\Component\HttpFoundation\Request;

final class ViewActionTest extends AbstractTestCase
{
    public function testView(): void
    {
        self::ensureKernelShutdown();
        $client = self::createClient();

        $crawler = $client->request(Request::METHOD_GET, uri: '/');
        self::assertResponseIsSuccessful();

        $repositories = $crawler->filter('.repository');
        self::assertCount(2, $repositories);

        $repository1 = $repositories->first();
        self::assertEquals('name1', $repository1->filter('.repo-name > p')->first()->text());
        self::assertEquals('description1', $repository1->filter('.repo-description > p')->first()->text());
        self::assertEquals(Language::Php->value, $repository1->filter('.repo-info > a')->first()->text());
        self::assertEquals(
            'https://github.com/TemKaa1337/repo1',
            $repository1->filter('.repo-info > a')->eq(1)->attr('href'),
        );
        self::assertEquals(
            'https://github.com/TemKaa1337/repo1.git',
            $repository1->filter('.repo-info > a')->eq(2)->attr('href'),
        );
        self::assertEquals('Created at: 20.03.2022 13:57:22', $repository1->filter('.repo-info > a')->eq(3)->text());
        self::assertEquals('Updated at: 20.03.2022 13:57:22', $repository1->filter('.repo-info > a')->eq(4)->text());
        self::assertEquals('https://demo1.url', $repository1->filter('.repo-info > a')->eq(5)->attr('href'));

        $repository2 = $repositories->last();
        self::assertEquals('name2', $repository2->filter('.repo-name > p')->first()->text());
        self::assertEquals('description2', $repository2->filter('.repo-description > p')->first()->text());
        self::assertEquals(Language::JavaScript->value, $repository2->filter('.repo-info > a')->first()->text());
        self::assertEquals(
            'https://github.com/TemKaa1337/repo2',
            $repository2->filter('.repo-info > a')->eq(1)->attr('href'),
        );
        self::assertEquals(
            'https://github.com/TemKaa1337/repo2.git',
            $repository2->filter('.repo-info > a')->eq(2)->attr('href'),
        );
        self::assertEquals('Created at: 01.03.2022 13:57:22', $repository2->filter('.repo-info > a')->eq(3)->text());
        self::assertEquals('Updated at: 20.03.2022 13:57:22', $repository2->filter('.repo-info > a')->eq(4)->text());
        self::assertEquals('#', $repository2->filter('.repo-info > a')->eq(5)->attr('href'));
        self::assertEquals('(currently no demo link provided)', $repository2->filter('.repo-info > a')->eq(5)->text());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->loadFixtures();
    }
}
