<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class InvalidCartException extends Exception
{
    /**
     * Create an exception for an empty cart.
     *
     * @return static
     */
    public static function emptyCart(): self
    {
        return new self('Le panier est vide.');
    }

    /**
     * Create an exception for a missing product.
     *
     * @param int $productId The ID of the missing product.
     * @return static
     */
    public static function productNotFound(int $productId): self
    {
        return new self("Le produit avec l'ID {$productId} n'existe pas.");
    }

    /**
     * Create an exception for an inactive product.
     *
     * @param string $productName The name of the inactive product.
     * @return static
     */
    public static function productNotActive(string $productName): self
    {
        return new self("Le produit '{$productName}' n'est pas disponible.");
    }

    /**
     * Create an exception for insufficient stock.
     *
     * @param string $productName The name of the product with insufficient stock.
     * @param int $requested The requested quantity.
     * @param int $available The available quantity.
     * @return static
     */
    public static function insufficientStock(string $productName, int $requested, int $available): self
    {
        return new self("Stock insuffisant pour '{$productName}'. Demandé: {$requested}, Disponible: {$available}.");
    }
}
