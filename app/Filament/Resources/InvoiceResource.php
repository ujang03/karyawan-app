<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'nama')
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('detail')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('total')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->maxValue(42949672.95),
                Forms\Components\DatePicker::make('issue_date')
                    ->required(),
                Forms\Components\DatePicker::make('due_date')
                    ->required(),
                Forms\Components\DatePicker::make('paid_date'),
            ]);
    }

    public static function table(Table $table): Table
    // {
    //     return $table
    //         ->columns([
    //             //
    //             Tables\Columns\TextColumn::make('project.nama')
    //                 ->numeric()
    //                 ->sortable(),
    //             Tables\Columns\TextColumn::make('title')
    //                 ->searchable(),
    //             Tables\Columns\TextColumn::make('total')
    //                 ->money('IDR')
    //                 ->sortable(),
    //             Tables\Columns\TextColumn::make('issue_date')
    //                 ->date()
    //                 ->sortable(),
    //             Tables\Columns\TextColumn::make('due_date')
    //                 ->date()
    //                 ->sortable(),
    //             Tables\Columns\TextColumn::make('paid_date')
    //                 ->date()
    //                 ->sortable(),
    //             Tables\Columns\TextColumn::make('created_at')
    //                 ->dateTime()
    //                 ->sortable()
    //                 ->toggleable(isToggledHiddenByDefault: true),
    //             Tables\Columns\TextColumn::make('updated_at')
    //                 ->dateTime()
    //                 ->sortable()
    //                 ->toggleable(isToggledHiddenByDefault: true),
    //         ])
    //         ->filters([
    //             //
    //         ])
    //         ->actions([
    //             Tables\Actions\EditAction::make(),
    //         ])
    //         ->bulkActions([
    //             Tables\Actions\BulkActionGroup::make([
    //                 Tables\Actions\DeleteBulkAction::make(),
    //             ]),
    //         ]);
    // }

    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('issue_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('paid_date')
                    ->date()
                    ->sortable()
                    ->placeholder('Belum dibayar'),
                Tables\Columns\IconColumn::make('is_paid')
                    ->label('Status')
                    ->boolean()
                    ->getStateUsing(fn($record) => !is_null($record->paid_date))
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->filters([
                Tables\Filters\Filter::make('paid')
                    ->label('Sudah Dibayar')
                    ->query(fn(Builder $query) => $query->whereNotNull('paid_date')),
                Tables\Filters\Filter::make('unpaid')
                    ->label('Belum Dibayar')
                    ->query(fn(Builder $query) => $query->whereNull('paid_date')),
            ])
            ->actions([
                Tables\Actions\Action::make('print')
                    ->label('Print')
                    ->icon('heroicon-o-printer')
                    ->url(fn(Invoice $record) => route('invoices.print', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\Action::make('download')
                    ->label('Download PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn(Invoice $record) => route('invoices.download', $record)),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);




        return $table
            ->columns([
                // ... columns yang sudah ada
            ])
            ->filters([
                // ... filters yang sudah ada
            ])
            ->actions([
                // ... actions yang sudah ada
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('printSelected')
                        ->label('Print Selected')
                        ->icon('heroicon-o-printer')
                        ->action(function ($records) {
                            $invoiceIds = $records->pluck('id')->toArray();
                            return redirect()->route('invoices.bulk-print', ['ids' => $invoiceIds]);
                        }),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }


    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}
