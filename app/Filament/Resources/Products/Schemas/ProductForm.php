<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->label('Категория')
                    ->relationship('category', 'name')
                    ->required(),
                TextInput::make('name')
                    ->label('Название')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                TextInput::make('sku')
                    ->label('Артикул'),
                TextInput::make('price')
                    ->label('Цена')
                    ->required()
                    ->numeric()
                    ->suffix('₽'),
                TextInput::make('old_price')
                    ->label('Старая цена')
                    ->numeric()
                    ->suffix('₽'),
                Textarea::make('short_description')
                    ->label('Короткое описание')
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->label('Описание (Markdown)')
                    ->rows(10)
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('gallery')
                    ->label('Галерея')
                    ->collection('gallery')
                    ->multiple()
                    ->reorderable()
                    ->image()
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('documents')
                    ->label('Документы')
                    ->collection('documents')
                    ->multiple()
                    ->columnSpanFull(),
                Select::make('attributeValues')
                    ->label('Значения атрибутов')
                    ->relationship('attributeValues', 'value')
                    ->multiple()
                    ->preload()
                    ->columnSpanFull(),
                Toggle::make('in_stock')
                    ->label('В наличии')
                    ->required(),
                Toggle::make('is_new')
                    ->label('Бейдж NEW')
                    ->required(),
                TextInput::make('meta_title'),
                TextInput::make('meta_description'),
            ]);
    }
}
