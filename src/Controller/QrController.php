<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class QrController extends AbstractController
{
    #[Route('/generate_qr/{description}/{startDate}/{endDate}', name: 'generate_qr')]
    public function generateQrCode($description, $startDate, $endDate): Response
    {
        // Concatenate product information into a single string
        $productInfo = "description: $startDate\startDate: $endDate\ endDate:";

        // Create the QR code using the concatenated product information
        $qrCode = new QrCode($productInfo);
        $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::High);
        $qrCode->setMargin(10);
        $qrCode->setEncoding(new Encoding('UTF-8'));
        $qrCode->setSize(300);

        // Generate the QR code image
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Return the QR code image as a response
        return new Response($result->getString(), 200, [
            'Content-Type' => 'image/png',
        ]);
    }
}