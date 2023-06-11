<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class HttpException extends Exception
{
    public function report(): void
    {
        try {
            $logger = app(LoggerInterface::class);
        } catch (Throwable $ex) {
            throw $this;
        }

        $logger->notice(
            $this->getMessage(),
            array_merge(
                $this->context(),
                ['exception' => $this],
            ),
        );
    }

    public function render(Request $request): Response
    {
        return $request->wantsJson()
            ? response()->json(['message' => $this->getMessage()], $this->getCode())
            : response($this->getMessage(), $this->getCode());
    }

    protected function context(): array
    {
        return [];
    }
}
