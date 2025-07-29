<?php

return [
  \App\Domain\Enums\OrderStatusEnum::RECEIVED->value => 'Commande reçue',
  \App\Domain\Enums\OrderStatusEnum::PROCESSING->value => 'En préparation ',
  \App\Domain\Enums\OrderStatusEnum::SHIPPED->value => 'Expédiée',
  \App\Domain\Enums\OrderStatusEnum::DELIVERED->value => 'Livrée'
];
