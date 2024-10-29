<?php

use App\Strategy\Admin\{AdminCreateStrategy, AdminUpdateStrategy};
use App\Strategy\Client\ClientRegisterStrategy;
use App\Strategy\Company\CompanyUpdateStrategy;
use App\Strategy\Product\ProductCategoryStrategy;
use App\Strategy\Product\ProductDeleteMultipleStrategy;
use App\Strategy\Product\ProductIndexStrategy;
use App\Strategy\Generic\{GenericUpdateStrategy, GenericShowStrategy, GenericListStrategy, GenericIndexStrategy,
    GenericCreateStrategy, GenericDeleteStrategy};

return [
    //TODO - copiar esse grupo genérico quando for CRUD Simples
//    'GenericController' => [
//        'index' => GenericIndexStrategy::class,
//        'show' => GenericShowStrategy::class,
//        'create' => GenericCreateStrategy::class,
//        'update' => GenericUpdateStrategy::class,
//        'delete' => GenericDeleteStrategy::class,
//        'list' => GenericListStrategy::class,
//    ],


    'AdminController' => [
        'index' => GenericIndexStrategy::class,
        'show' => GenericShowStrategy::class,
        'create' => AdminCreateStrategy::class,
        'update' => AdminUpdateStrategy::class,
        'delete' => GenericDeleteStrategy::class,
        'list' => GenericListStrategy::class,
    ],
    'AddressController' => [
        'index' => GenericIndexStrategy::class,
        'show' => GenericShowStrategy::class,
        'create' => GenericCreateStrategy::class,
        'update' => GenericUpdateStrategy::class,
        'delete' => GenericDeleteStrategy::class,
        'list' => GenericListStrategy::class,
    ],
    'CategoryController' => [
        'index' => GenericIndexStrategy::class,
        'show' => GenericShowStrategy::class,
        'create' => GenericCreateStrategy::class,
        'update' => GenericUpdateStrategy::class,
        'delete' => GenericDeleteStrategy::class,
        'list' => GenericListStrategy::class,
    ],
    'CityController' => [
        'index' => GenericIndexStrategy::class,
        'show' => GenericShowStrategy::class,
        'list' => GenericListStrategy::class,
    ],
    'CompanyController' => [
        'index' => GenericIndexStrategy::class,
        'show' => GenericShowStrategy::class,
        'create' => GenericCreateStrategy::class,
        'update' => CompanyUpdateStrategy::class,
        'delete' => GenericDeleteStrategy::class,
        'list' => GenericListStrategy::class,
    ],
    'CountryController' => [
        'index' => GenericIndexStrategy::class,
        'show' => GenericShowStrategy::class,
        'list' => GenericListStrategy::class,
    ],
    'DispatcherAgencyController' => [
        'index' => GenericIndexStrategy::class,
        'show' => GenericShowStrategy::class,
        'list' => GenericListStrategy::class,
    ],
    'FinancialMovementController' => [
        'index' => GenericIndexStrategy::class,
        'show' => GenericShowStrategy::class,
        'create' => GenericCreateStrategy::class,
        'update' => GenericUpdateStrategy::class,
        'delete' => GenericDeleteStrategy::class,
        'list' => GenericListStrategy::class,
    ],
    'ModalityController' => [
        'index' => GenericIndexStrategy::class,
        'show' => GenericShowStrategy::class,
        'create' => GenericCreateStrategy::class,
        'update' => GenericUpdateStrategy::class,
        'delete' => GenericDeleteStrategy::class,
        'list' => GenericListStrategy::class,
    ],
    'StateController' => [
        'index' => GenericIndexStrategy::class,
        'show' => GenericShowStrategy::class,
        'list' => GenericListStrategy::class,
    ],
    'PaymentController' => [
        'index' => GenericIndexStrategy::class,
        'show' => GenericShowStrategy::class,
        'create' => GenericCreateStrategy::class,
        'update' => GenericUpdateStrategy::class,
        'delete' => GenericDeleteStrategy::class,
        'list' => GenericListStrategy::class,
    ],
    'PaymentConditionController' => [
        'index' => GenericIndexStrategy::class,
        'show' => GenericShowStrategy::class,
        'create' => GenericCreateStrategy::class,
        'update' => GenericUpdateStrategy::class,
        'delete' => GenericDeleteStrategy::class,
        'list' => GenericListStrategy::class,
    ],
    'PlanController' => [
        'index' => GenericIndexStrategy::class,
        'show' => GenericShowStrategy::class,
        'create' => GenericCreateStrategy::class,
        'update' => GenericUpdateStrategy::class,
        'delete' => GenericDeleteStrategy::class,
        'list' => GenericListStrategy::class,
    ],
    'SaleController' => [
        'index' => GenericIndexStrategy::class,
        'show' => GenericShowStrategy::class,
        'create' => GenericCreateStrategy::class,
        'update' => GenericUpdateStrategy::class,
        'delete' => GenericDeleteStrategy::class,
        'list' => GenericListStrategy::class,
    ],
    'DashboardController' => [
        'home' => DashboardHomeStrategy::class,
    ],
    'ProductController' => [
        'index' => ProductIndexStrategy::class,
        'category' => ProductCategoryStrategy::class,
        'show' => GenericShowStrategy::class,
        'create' => GenericCreateStrategy::class,
        'update' => GenericUpdateStrategy::class,
        'delete' => GenericDeleteStrategy::class,
        'deleteMultiple' => ProductDeleteMultipleStrategy::class,
        'list' => GenericListStrategy::class,
    ],
    'ClientController' => [
        'index' => GenericIndexStrategy::class,
        'show' => GenericShowStrategy::class,
        'create' => GenericCreateStrategy::class,
        'update' => GenericUpdateStrategy::class,
        'delete' => GenericDeleteStrategy::class,
        'list' => GenericListStrategy::class,
        'register' => ClientRegisterStrategy::class,
    ],
]; // NOTE - Alphabetical Order
