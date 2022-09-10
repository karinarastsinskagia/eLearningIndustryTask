<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Article;
use App\Http\Resources\ExternalServiceResource;

class ExternalServiceController extends Controller
{   
    /*
        External Service Definition
    */
    public function __construct()
    {   
        $credentials = 'my-unique_token-12';
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'https://lapi.external-services.com/v2/',
            'headers' => [
                'Authorization' => 'Basic '.$credentials,
                'Accept' => 'application/vnd.api+json',
            ]
           
        ]);

        $this->client = $client;

        $this->sendAllUrl = 'articles';
        $this->articleUrl = 'article';
        
    }

    /*
        collect All Articles Information in a json body an send it to external service
    */

    public function sendAll(){

        $articles = DB::table('articles')->get();

        $allInfo = [];
        $articlesComments =[];

        foreach ($articles as $article) {

            $newArticleObject = new ArticleResource($article);

            $artcile_id = $article->id;
            $article = Article::find($artcile_id);
            

            foreach ($article->comments as $comment) {
                
                $newCommentObject = new CommentResource($comment);
                array_push($articlesComments,$newCommentObject);
            }

            $new = array( 'Article'=>$newArticleObject, 'Comments' => $articlesComments);
            array_push($allInfo, $new);
            $articlesComments =[];
        }

        $body = json_encode($allInfo);
        //print_r($body);
        
        $this->ExternalServiceRequest('sendAll',$this->sendAllUrl,$body);


    }

    public function ExternalServiceCreateArticle(ExternalServiceResource $request){

       $body = json_encode($request);
       $this->ExternalServiceRequest('post',$this->articleUrl,$body);

    }

    public function ExternalServiceEditArticle(ExternalServiceResource $request){
        
        $body = json_encode($request);
        //print_r($body);
        $article_id = $request['id'];
        $url = $this->articleUrl.'/'.$article_id;
        $this->ExternalServiceRequest('update',$url,$body);
    
    }

    public function ExternalServiceDeleteArticle($id){

        $url = $this->articleUrl.'/'.$id;
        $this->ExternalServiceRequest('delete',$url);
      
    }

    private function ExternalServiceRequest($request,$url,$body = null){


        /*switch($request) {
            case('sendAll'):
                $request = $this->client->post($url, ['body'=>$body]);
                break;
            case('post'):
                $request = $this->client->post($url, ['body'=>$body]);
                break;
            case('update'):
                $request = $this->client->put($url, ['body'=>$body]);
                break;
            case('delete'):
                $request = $this->client->delete($url);
                break;
            default:
                echo 'Something went wrong.';
                exit;

        }

        $response = $request->send();
        dd($response);*/
    }
    
}
