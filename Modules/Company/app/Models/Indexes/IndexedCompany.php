<?php

namespace Modules\Company\Models\Indexes;

use Illuminate\Database\Schema\Blueprint;
use Modules\Company\Models\Company;
use PDPhilip\ElasticLens\Builder\IndexBuilder;
use PDPhilip\ElasticLens\Builder\IndexField;
use PDPhilip\ElasticLens\IndexModel;

class IndexedCompany extends IndexModel {
    protected $baseModel = Company::class;

    public function fieldMap(): IndexBuilder
    {
        return IndexBuilder::map(Company::class, function (IndexField $field) {
            $field->text("name");
        });
    }
    public function migrationMap(): callable
    {
        return function (Blueprint $index) {
            $index->text('name');
            $index->text('description');
        };
    }
}