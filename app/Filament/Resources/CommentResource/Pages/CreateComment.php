<?php

namespace App\Filament\Resources\CommentResource\Pages;

use App\Filament\Resources\CommentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateComment extends CreateRecord
{
    protected static string $resource = CommentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // ambil fariable
        $text = $data['content'];
        if (strlen($text) > 50) {
            $data['content'] = substr($text, 0, 50); // Batasi panjang title
        }
        // dd($text);



        $data['post_id'] = auth()->user()->id;
        $data['user_id'] = 1;
        $data['created_at'] = now(); // Misalnya, set created_at ke waktu sekarang
        return $data;
    }

    protected function mutateFormDataBeforeUpdate(array $data): array
    {
        // Tambahkan logika sebelum mengupdate data
        $data['updated_at'] = now(); // Misalnya, set updated_at ke waktu sekarang
        return $data;
    }
}
