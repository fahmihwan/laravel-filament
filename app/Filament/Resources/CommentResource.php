<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Filament\Resources\CommentResource\RelationManagers;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {
        // dd("Dsdsd");
        return $form
            ->schema([
                //description
                Forms\Components\Card::make()
                    ->schema([
                        Textarea::make('content')
                            ->label('Description')
                            ->placeholder('Description')
                            ->rows(5)
                            ->required(),


                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {

        $raw = DB::select("select * from posts");
        // dd(fet);
        // $this->fetchPosts();
        $comment =  new CommentResource();
        $fetchApi  = $comment->fetchPosts();


        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
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
            'index' => Pages\ListComments::route('/'),
            'create' => Pages\CreateComment::route('/create'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }

    public function index()
    {
        // Mengambil data dari JSONPlaceholder
        $url = "https://jsonplaceholder.typicode.com/posts";
        $response = file_get_contents($url);
        return response()->json(json_decode($response));
    }

    public function fetchPosts()
    {
        // Mengambil data dari JSONPlaceholder menggunakan cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://jsonplaceholder.typicode.com/posts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true); // Mengembalikan hasil sebagai array
    }
}
