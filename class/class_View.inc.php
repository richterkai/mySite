<?php
//class/class_View.inc.php
class VIEW{
    private $img; //hier das Bild
    private $blue;// Hintergrund
    private $lightblue;// Scalierung
    private $white;// Zeichen
    private $red;//Polygon
    private $w = 1200;//Proportion Hintergrund
    private $h = 800;
    private $fontpath = 'fonts/Lobster-Regular.ttf';//absoluter Path
    private $max;// maximale Faelle für y Achse
    private $arr;//woche,faelle
    private $steps_v; // vertikale Scalierung
    private $steps_h; // horizontale Scalierung
    private $maxround; 
    private $teiler;
    
    public function __construct($max,$arr){
        $this->max = $max; 
        $this->arr = $arr;
        $this->steps_v = $this->w / 52; // Wochen
        // Teiler
        echo "Fälle Höchstwert: " . $this->max . "<br>";
        echo "Gesammte Fälle: " . $this->getAllCovidFaelle() . "<br>";
        switch(true){
            case ($this->max <= 1500) : $this->teiler = 100;
            break;
            case ($this->max <= 8000) : $this->teiler = 300;
            break;
            default: $this->teiler = 500;
            }
        $this->maxround = round($this->max+50,-2);//später aus Datenbank Bild größer als maximaler wert
        $this->steps_h = $this->h/($this->maxround/$this->teiler);
        $this->setBackground();//Instanz erstellen color wird aufgerufen
        //$this->setBeispiel();
        $this->setVertical();//Scalierung
        $this->setHorizontal();
        $this->setPolygon();
        $this->imageSave();
    }
    function getAllCovidFaelle(){
        $sum = 0;
        foreach($this->arr as $index=>$value){
            if(!$index % 2 == 0)$sum += $value;
        }
        return $sum;
    }
    function setColor(){
            $this->lightblue = imagecolorallocate($this->img,150,150,255);
            $this->white = imagecolorallocate($this->img,255,255,255);
            $this->blue = imagecolorallocate($this->img,0, 0, 181);
            $this->red = imagecolorallocate($this->img,255,0,0);
    }
    
    function setPolygon(){
        $arr = $this->arr;
        //$max = 1433;//maximaler Testwert
        //$arr = [10,100 , 15,250 , 22,1400];//aus Datenbank
        foreach($arr as $index=>$value){
          if($index % 2 == 0){// alle geraden sind die Wochen
              $arr[$index] = $arr[$index]*$this->steps_v - $this->steps_v;//Abstände - 1 Woche
          }
          else{
              $diff= $arr[$index]*100/$this->maxround;//Prozentualer Anteil zu 1500 Fälle
              $arr[$index] =  $this->h - $diff*$this->h/100;//Prozentualer Anteil zu Höhe
              //$arr[$index] =  ($this->h  *  ($maxround/$this->h)- $arr[$index])/($maxround/$this->h);
              }
            
        }
        $points = count($arr)/2;//Hälfte des Arrays
        // Array ,menge der Punkte ist gerade
        imagesetthickness($this->img,3); 
        imageopenpolygon($this->img,$arr,$points,$this->red);
    }
    
    function setVertical(){
        $week = 0;
        for($i=0;$i<=$this->w;$i+=$this->steps_v){
           imageline($this->img,$i,0,$i,$this->h,$this->lightblue);
           imagettftext($this->img,5,0,$i+$this->steps_v/2,$this->h-10,$this->white,realpath($this->fontpath),++$week);
        } 
     }
    
    function setHorizontal(){
        //$max = 1433;
        $maxround = $this->maxround;
        for($i=0;$i<=$this->h;$i+=$this->steps_h){
            imageline($this->img,0,$i,$this->w,$i,$this->lightblue);
            imagettftext($this->img,5,0,5,$i+$this->steps_h,$this->white,realpath($this->fontpath),$maxround -=$this->teiler);
        }
    }

    function setBeispiel(){
     $color =  imagecolorallocate($this->img,255,255,0);
     //Breite Linie in Pixeln
     imagesetthickness($this->img,5);     
     //Rechteck x1,y1,x2,y2,color
     imagerectangle($this->img,50,50,100,100, $color);
     // Füllungen
     imagefilledrectangle($this->img,150,50,200,100, $color);
     //Ellipse Mittelpunkt x,y weite höhe
     imageellipse($this->img,250,75,50,50,$color);
     //filled Ellipse
     imagefilledellipse($this->img,325,75,50,100,$color);
     //linie x1,y1,x2,y2
     imagesetthickness($this->img,2);
     $red =  imagecolorallocate($this->img,255,0,0);  
     imageline($this->img,50,150,300,200,$red);
     imagefilter($this->img,IMG_FILTER_GAUSSIAN_BLUR,0.5);
     //Pixel x,y,color  
     imagesetpixel($this->img,50,350,$red); 
     //mehrere Pixel mit Zufallswert   
     for($i=0;$i<= 300;$i++){
       $color = imagecolorallocate($this->img,rand(0,255),rand(0,255),rand(0,255));
       imagesetpixel($this->img,rand(50,100),rand(250,300),$color);
     }
     //Farbwert in Bild ermitteln x,y Position
        $rgb = imagecolorat($this->img,75,275);
        $arr = imagecolorsforindex($this->img,$rgb);//Umrechnung
        $txt = '';
        foreach($arr as $key=>$value){
            $txt .= $key.':'.$value.' ';
        }
        
      //Schreiben 
       $white = imagecolorallocate($this->img,255,255,255);
      //Textgröße 1..5,x,y,text,farbe    
      //imagestring($this->img,5,50,400,$txt,$white ); 
      // Größe pix,Winkel deg, x,y, color, font ,text 
      $path = realpath('fonts/Lobster-Regular.ttf');//absoluter Path
      imagettftext($this->img,20,0,50,400,$white,$path,$txt);
        //Filter 
    }

    function setBackground(){
        //GD Bibliothek Dimension x y
        $this->img = imagecreatetruecolor($this->w,$this->h);
        $this->setColor();//GD Farbe festlegen für welches image RGB
        //Fülle ab der Position xy 
        imagefill($this->img,0,0,$this->blue);
    }
    function imageSave(){
        //gif bmp web
        imagepng($this->img,"grafik.png");
        // imagejpg($this->img,"grafik.jpg",80);
    }
    public function __destruct(){
        imagedestroy($this->img);// aus Speicher entfernen
    }
}


?>