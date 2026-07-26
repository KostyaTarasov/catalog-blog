<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Заголовок')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),
                Textarea::make('excerpt')
                    ->label('Анонс')
                    ->columnSpanFull(),
                Textarea::make('lead')
                    ->label('Лид-абзац')
                    ->columnSpanFull(),
                Textarea::make('content')
                    ->label('Контент (Markdown)')
                    ->rows(16)
                    ->columnSpanFull(),
                SpatieMediaLibraryFileUpload::make('cover')
                    ->label('Обложка')
                    ->collection('cover')
                    ->image()
                    ->columnSpanFull(),
                Select::make('tags')
                    ->label('Теги')
                    ->relationship('tags', 'name')
                    ->multiple()
                    ->preload(),
                DateTimePicker::make('published_at')
                    ->label('Дата публикации'),
                TextInput::make('meta_title'),
                TextInput::make('meta_description'),
            ]);
    }
}
