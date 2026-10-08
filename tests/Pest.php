<?php

declare(strict_types=1);

use Rawilk\Printing\Drivers\Cups\Entity\Printer;
use Rawilk\Printing\Drivers\Cups\Entity\PrintJob;
use Rawilk\Printing\Tests\Feature\Api\PrintNode\PrintNodeTestCase;
use Rawilk\Printing\Tests\TestCase;
use Smalot\Cups\Model\Job;

uses(TestCase::class)->in('Feature/FactoryTest.php');
uses(TestCase::class)->in('Feature/PrintingTest.php');
uses(TestCase::class)->in('Feature/Receipts');
uses(TestCase::class)->in('Feature/Api/PrintNode/Entity');
uses(PrintNodeTestCase::class)->in('Feature/Api/PrintNode/Requests');
uses(TestCase::class)->in('Feature/Drivers');

// Helpers
function samplePrintNodeData(string $file): array
{
    return json_decode(
        file_get_contents(__DIR__ . "/stubs/Api/PrintNode/{$file}.json"),
        true
    );
}

function createCupsJob(): PrintJob
{
    $cupsJob = new Job;
    $cupsJob->setId(123456)
        ->setName('my print job')
        ->setState('success');

    return new PrintJob($cupsJob, createCupsPrinter());
}

function createCupsPrinter(): Printer
{
    $cupsPrinter = new Smalot\Cups\Model\Printer;
    $cupsPrinter->setName('printer-name')
        ->setUri('localhost:631')
        ->setStatus('online');

    return new Printer($cupsPrinter, test()->jobManager);
}
