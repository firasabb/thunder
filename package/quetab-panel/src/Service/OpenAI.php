<?php
namespace Quetab\QuetabPanel\Service;
use Illuminate\Support\Facades\Http;
  
class OpenAI{
    

    private static function getBaseURL(){
        return config('quetab.openai.base_url');
    }

    private static function getKey(){
        return config('quetab.openai.key');
    }

    /**
     * 
     * Moderate the input
     * Before sending the input to the OpenAI API, we need to moderate it
     * @param string $input
     * @return boolean
     * 
     */
    public static function moderateInput($input){

        $url = Self::getBaseURL() . '/moderations';
        $authKey = Self::getKey();

        $prepare = json_encode([
            "input"     =>  $input
        ]);

        try{

            $response = Http::withToken(
                $authKey
            )->withBody($prepare, 'application/json')->post($url);
    
            $response = json_decode($response, true);

        } catch(\Exception $e){
            return false;
        }

        if($response){
            if( isset($response['results'])
                && isset($response['results'][0])
                && isset($response['results'][0]['flagged'])
            ){
                return !filter_var($response['results'][0]['flagged'], FILTER_VALIDATE_BOOLEAN);
            }
        }

        return $response;
    }

    


    /**
     * 
     * Get text completions
     * 
     */
    public static function getTextCompletions($context, $user = null, $model = 'text-davinci-003', $maxTokens = 300){
            
        $url = config('services.openai.base_url') . '/completions';
        $token = config('services.openai.token');


        if(!$maxTokens){
            $maxTokens = $user && $user->isPremium() ? 2048 : 300;
        }

        $prepare = json_encode([
            "model" => $model,
            "prompt" => $context,
            "temperature" => 0,
            "max_tokens" => $maxTokens,
            "top_p" => 1,
            "frequency_penalty" => 0.5,
            "presence_penalty" => 0
        ]);

        // Moderate the input
        $moderate = OpenAI::moderateInput($context);
        if(!$moderate){
            return 'flagged';
        }
        
        try{

            $response = Http::withToken(
                $token
            )->withBody($prepare, 'application/json')->post($url);

            return json_decode($response, true);    

        } catch(\Exception $e){
            return 'something went wrong';
        }

        return 'something went wrong';
    }



    public static function getChatCompletions($context, $user = null, $model = 'gpt-4', $maxTokens = 300){
            
        $url = config('services.openai.base_url') . '/chat/completions';
        $token = config('services.openai.token');

        if(!$maxTokens){
            $maxTokens = $user && $user->isPremium() ? 2048 : 300;
        }

        $prepare = json_encode([
            "model" => $model,
            "temperature" => 0,
            "max_tokens" => $maxTokens,
            "top_p" => 1,
            "frequency_penalty" => 0.5,
            "presence_penalty" => 0,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $context
                ]
            ]
        ]);

        // Moderate the input
        $moderate = OpenAI::moderateInput($context);
        if(!$moderate){
            return 'flagged';
        }
        
        try{

            $response = Http::withToken(
                $token
            )->withBody($prepare, 'application/json')->post($url);

            return json_decode($response, true);    

        } catch(\Exception $e){
            return 'something went wrong';
        }

        return 'something went wrong';
    }



    public static function getImageGeneration($context, $options = []){
            
        $url = config('services.openai.base_url') . '/images/generations';
        $token = config('services.openai.token');

        $model = isset($options['model']) ? $options['model'] : 'dall-e-3';
        $n = isset($options['n']) ? $options['n'] : 1;
        $quality = isset($options['quality']) ? $options['quality'] : 'hd';
        $size = isset($options['size']) ? $options['size'] : '1024x1024';

        $prepare = json_encode([
            "model"     => $model,
            "prompt"    => $context,
            'quality'   => $quality,
            "n"         => $n,
            "size"      => $size,
        ]);

        // Moderate the input
        $moderate = OpenAI::moderateInput($context);
        if(!$moderate){
            return 'flagged';
        }
        
        $response = Http::withToken(
            $token
        )->withBody($prepare, 'application/json')->post($url);

        return json_decode($response, true);   

        try{

            $response = Http::withToken(
                $token
            )->withBody($prepare, 'application/json')->post($url);

            return json_decode($response, true);    

        } catch(\Exception $e){
            return 'something went wrong';
        }

        return 'something went wrong';
    }


    public static function userAppRequest($options){

        $context = $options['context'];
        $model = $options['model'];
        $token = $options['token'];
        $prompt = $options['prompt'];
        $messages = $options['messages'];

        $prepare = [
            "model" => $model,
            "temperature" => 0,
            "max_tokens" => 300,
            "top_p" => 1,
            "frequency_penalty" => 0.5,
            "presence_penalty" => 0
        ];

        if($messages){
            $messages = json_decode($messages, true);

            if(!$context){
                // assing the context to the last element of the messages array
                $last = count($messages) - 1;
                $context = $messages[$last]['content'];
            }

        }

        // Parse the context
        if($prompt){
            if(strpos($prompt, '[input]') !== FALSE){
                $context = str_replace('[input]', $context, $prompt);
            }
        }

        // Check models
        if($model == 'gpt-3.5-turbo' || $model == 'gpt-4'){

            if(!$messages){
                $messages = [
                    [
                        'role' => 'user',
                        'content' => $context
                    ]
                ];   
            }

            $url = config('services.openai.base_url') . '/chat/completions';

            $prepare['messages'] = $messages;
            
        } else {
            $url = config('services.openai.base_url') . '/completions';
            $prepare['prompt'] = $context;
        }

        $prepare = json_encode($prepare);

        // Moderate the input
        $moderate = OpenAI::moderateInput($context, $token);
        if(!$moderate){
            return 'flagged';
        }
        
        // Send the request
        try{
            $response = Http::withToken(
                $token
            )->withBody($prepare, 'application/json')->post($url);

            return json_decode($response, true);    

        } catch(\Exception $e){
            return 'something went wrong';
        }

        return 'something went wrong';
    }


    public static function getAnswer($context){

        $response = "";

        $context = 'Answer the following question in detail: ' . $context;
        try{
            $text = Self::getChatCompletions($context, null, 'gpt-4', 800);

            if(isset($text['choices']) 
                && isset($text['choices'][0]) 
                && isset($text['choices'][0]['message']) 
                && isset($text['choices'][0]['message']['content'])){

                $response = $text['choices'][0]['message']['content'];
            }
        } catch(\Exception $e){
            return null;
        }

        return $response;

    }


    public static function getChatCompletionsText($context, $user = null){

        $response = "";
        $call = Self::getChatCompletions($context, $user, 'gpt-4', 2048);

        if(isset($call['choices']) 
            && isset($call['choices'][0]) 
            && isset($call['choices'][0]['message']) 
            && isset($call['choices'][0]['message']['content'])){

                $response = $call['choices'][0]['message']['content'];
        }

        return $response;

    }


    /** 
     * 
     * Parse the question response
     * @param string $response
     * @return array
     * 
    */
    public static function parseQuestionResponse($response){

        $arr = [];

        $loops = 0;
        $i = 0;
        while(strpos($response, "Q:") !== false || strpos($response, "A:") !== false){
            
            $answerPosition = strpos($response, "Q:");
            $questionPosition = strpos($response, "A:");

            if(is_int($questionPosition) && is_int($answerPosition)){
                if($questionPosition < $answerPosition){
                    $question = substr($response, 0, $questionPosition);
                    $arr[$i]["question"] = trim($question);
                    $response = substr($response, $questionPosition + 2, -1);

                } else {
                    $answer = substr($response, 0, $answerPosition);
                    $arr[$i]["answer"] = trim($answer);
                    $response = substr($response, $answerPosition + 2, -1);

                }
            } else if(is_int($questionPosition)){
                $question = substr($response, 0, $questionPosition);
                $arr[$i]["question"] = trim($question);
                $response = substr($response, $questionPosition + 2, -1);
            } else if(is_int($answerPosition)){
                $answer = substr($response, 0, $answerPosition);
                $arr[$i]["answer"] = trim($answer);
                $response = substr($response, $answerPosition + 2, -1);
            } else {
                $arr[$i]['answer'] = trim($response);
                $response = "";
            }
            $i++;
        } 

        if($arr){
            $newArr = [];
            $element = [];
            foreach($arr as $key => $value){
                if(isset($value['answer']) && $value['answer']){
                    $element['answer'] = $value['answer'];
                }
                if(isset($value['question']) && $value['question']){
                    $element['question'] = $value['question'];
                }
                if(isset($element['answer']) && isset($element['question'])){
                    $newArr[] = $element;
                    $element = [];
                }
            }
            $arr = $newArr;
        }
        return $arr;

    }

}