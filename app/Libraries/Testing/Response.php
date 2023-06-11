<?php

namespace App\Libraries\Testing;


use Illuminate\Testing\TestResponse;

/**
 * @mixin \Illuminate\Testing\TestResponse
 */
class Response extends TestResponse
{
    protected static array $successResponseStructure = [];
    protected static array $pagerMetaStructure = [
        'total',
        'count',
        'perPage',
        'currentPage',
        'totalPages',
        'links',
    ];

    public function assertJsonDataCollectionStructure(array $data, bool $includePagerMeta = true): self
    {
        $struct = self::$successResponseStructure;
        $struct['data'] = [$data];

        if ($includePagerMeta) {
            $struct['meta'] = [
                'pagination' => self::$pagerMetaStructure,
            ];
        }

        $this->assertJsonStructure($struct);

        return $this;
    }

    public function assertJsonDataItemStructure(array $data): self
    {
        $struct = ['data' => $data];

        $this->assertJsonStructure($struct);

        return $this;
    }

    public function assertJsonSuccessStructure(string $message = 'ok'): self
    {
        $this->assertJsonStructure(self::$successResponseStructure);
        $this->assertJson(['message' => 'ok']);

        return $this;
    }

    public function getDecodedContent(): array
    {
        $content = $this->getContent();

        return json_decode($content, true);
    }

    public function assertForbidden(): Response
    {
        parent::assertForbidden();

        return $this;
    }

    public function assertUnauthorized(): Response
    {
        parent::assertUnauthorized();

        $this->assertJson(['message' => 'Unauthenticated.']);

        return $this;
    }

    public function assertNotFound(): Response
    {
        parent::assertNotFound();

        $this->assertJson(['message' => __('app.item_not_found')]);

        return $this;
    }


    public function assertOk(): Response
    {
        parent::assertOk();

        return $this;
    }

    public function assertCreated(): Response
    {
        parent::assertCreated();

        $this->assertJsonSuccessStructure();

        return $this;
    }
}
