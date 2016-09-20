<?

/*
Nico Ariesto Gilani
Sarmag TI
*/

class latihan_pda {

   private $stack;
   private $limit;

   private $states=array();
   private $transition=array();
   private $currentState;
   private $errors;
   private $error;
   private $total;

   public function __construct($states,$transition,$limit=20) {
       $this->states=$states;
       $this->transition=$transition;

       $this->stack = array();
       $this->limit = $limit;

       $this->error=-1; //flag

       $this->errors[3]="Top stack bukan huruf a saat di Q2";
       $this->errors[4]="Stack sudah kosong, masih ada sisa inputan yang belum di pop";
       $this->errors[5]="Top stack bukan huruf b saat di Q2";
       $this->errors[6]="Bermasalah di huruf c";
       $this->errors[7]="Stack belum kosong";



       $this->errors[0]="karakter input salah";
       $this->errors[1]="state salah";
       $this->errors[2]="tidak berakhir pada final state";
   }

   //stack
   public function push($item){
     if (count($this->stack) < $this->limit) {
       array_unshift($this->stack, $item);
     } else {
       throw new RuntimeException('Stack penuh!');
     }
   }

   public function pop()
   {
     if($this->isEmpty()){
       throw new RunTimeException("Stack kosong!");
     } else {
       return array_shift($this->stack);
     }
   }

   public function top()
   {
     return current($this->stack);
   }

   public function isEmpty()
   {
     return empty($this->stack);
   }



   public function cek_input($input) {
       //cek state awal
       foreach ($this->states as $state => $type) {
           if ($type=="start") {
               $this->currentState=$state;
               break;
           }
       }

       $end=strlen($input);

       //cek perinputan
       for ($start=0;$start<$end;$start++) { //NAMBAH
           $char=substr($input,$start,1);

           switch ($char) {
             case 'a':
               //cek state, valid atau tidak
               if (isset($this->transition[$this->currentState])) {
                   if ($this->states[$this->currentState]=="kosong") {
                     if (isset($this->transition[$this->currentState][$char]) && ($this->top() == 'a') ) {
                         $this->currentState=$this->transition[$this->currentState][$char];
                         $this->pop();
                     }else{//jika alfabet input tidak valid
                         if ($this->isEmpty() == true) {
                           $this->set_error(4);
                           break;
                         }else{
                           $this->set_error(3);
                           break;
                         }
                     }
                   }else{
                     //cek state terdapat alfabet input atau tidak
                     if (isset($this->transition[$this->currentState][$char]) && $this->isEmpty() == true ) {
                         //update currentState dengan state tujuan
                         $this->currentState=$this->transition[$this->currentState][$char];
                         $this->push($char);
                         //cek state terbaru valid atau tidak
                         if (!$this->transition[$this->currentState]) {
                             $this->set_error(1);
                             break;
                         }
                     }elseif (isset($this->transition[$this->currentState][$char]) && ($this->top() == 'a' || $this->top() == 'b' ) ) {
                         $this->currentState=$this->transition[$this->currentState][$char];
                         $this->push($char);
                     }else{//jika alfabet input tidak valid
                         $this->set_error(4);
                         break;
                     }
                   }
               }else{//jika state tidak valid
                   $this->set_error(1);
                   break;
               }
               break;

             case 'b':
               //cek state, valid atau tidak
               if (isset($this->transition[$this->currentState])) {
                   if ($this->states[$this->currentState]=="kosong") {
                     if (isset($this->transition[$this->currentState][$char]) && ($this->top() == 'b') ) {
                         $this->currentState=$this->transition[$this->currentState][$char];
                         $this->pop();
                     }else{//jika alfabet input tidak valid
                         $this->set_error(5);
                         break;
                     }
                   }else{
                     //cek state terdapat alfabet input atau tidak
                     if (isset($this->transition[$this->currentState][$char]) && $this->isEmpty() == true ) {
                         //update currentState dengan state tujuan
                         $this->currentState=$this->transition[$this->currentState][$char];
                         $this->push($char);
                         //cek state terbaru valid atau tidak
                         if (!$this->transition[$this->currentState]) {
                             $this->set_error(1);
                             break;
                         }
                     }elseif (isset($this->transition[$this->currentState][$char]) && ($this->top() == 'a' || $this->top() == 'b' ) ) {
                         $this->currentState=$this->transition[$this->currentState][$char];
                         $this->push($char);
                     }else{//jika alfabet input tidak valid
                         $this->set_error(0);
                         break;
                     }
                   }
               }else{//jika state tidak valid
                   $this->set_error(1);
                   break;
               }
               break;

            case 'c':
              //cek state, valid atau tidak
              if (isset($this->transition[$this->currentState])) {
                  //cek state terdapat alfabet input atau tidak
                  if (isset($this->transition[$this->currentState][$char]) && $this->isEmpty() == true ) {
                      //update currentState dengan state tujuan
                      $this->currentState=$this->transition[$this->currentState][$char];
                      //cek state terbaru valid atau tidak
                      if (!$this->transition[$this->currentState]) {
                          $this->set_error(1);
                          break;
                      }
                  }elseif (isset($this->transition[$this->currentState][$char]) && ($this->top() == 'a' || $this->top() == 'b' ) ) {
                      $this->currentState=$this->transition[$this->currentState][$char];
                  }else{//jika alfabet input tidak valid
                      $this->set_error(6);
                      break;
                  }
              }else{//jika state tidak valid
                  $this->set_error(1);
                  break;
              }
              break;

            case ' ':
              //cek state, valid atau tidak
              if (isset($this->transition[$this->currentState])) {
                  //cek state terdapat alfabet input atau tidak
                  if (isset($this->transition[$this->currentState][$char]) && $this->isEmpty() == true ) {
                      //update currentState dengan state tujuan
                      $this->currentState=$this->transition[$this->currentState][$char];
                      //cek state terbaru valid atau tidak
                      // if (!$this->transition[$this->currentState]) {
                      //     $this->set_error(1);
                      //     break;
                      //}
                  }else{
                      $this->set_error(7);
                      //$this->top();
                      break;
                  }
              }else{//jika state tidak valid
                  $this->set_error(1);
                  break;
              }
              break;

            default:
               echo '<br /><h4 style="color:red;">'.$char.' suku kata yang tidak diterima</h4>';
               $this->set_error(0);
               break;
           }

       }//end for

       if ($this->error<0) {//jika flag tidak berubah
           //cek apa berhenti di final state
           if ($this->states[$this->currentState]=="final") {
               return true;
           }else{//jika tidak berhenti di final state
               $this->set_error(2);
               return false;
           }
       }else{
           return false;
       }
   }

   public function set_total(){
     return $this->total/2;
   }

   protected function set_error($errorCode) {
       $this->error=$errorCode;
   }

   public function show_error() {
       if ($this->error>=0) {
           return $this->errors[$this->error];
       }else{
           return "";
       }
   }
}

?>
