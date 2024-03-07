<?php

// src/Repository/MessageStreamRepository.php
namespace App\Repository;

use App\Entity\MessageStream;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MessageStreamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MessageStream::class);
    }

    // Add custom query methods if needed
}
