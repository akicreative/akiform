<?

namespace AkiCreative\AkiForms;

use Illuminate\Support\Str;

class Carousel
{

    var $id;
    var $showIndicators = true;
    var $showControls = false;
    var $items;
    var $carouselclass = 'mb-3 carousel-fade';

    public function __construct($items = [], $params = [])
    {

        $this->items = $items;

        foreach($params as $key => $val){

            $this->$key = $val;
        }

    }

    public function render()
    {

        $indicatoractive = 'active';
        $indicatorindex = 0;
        $itemactive = 'active';

        $items = $this->items;

        if(count($items) == 0){

            return '';
        }


        ob_start();

        echo '
            <div id="carousel' . $this->id . '" class="carousel slide ' . $this->carouselclass . '" data-ride="carousel">
        ';

        if($this->showIndicators) {

            echo '<ol class="carousel-indicators">';

            foreach ($items as $key => $value) {

                echo '
                <li data-target="#carousel' . $this->id . '" data-slide-to="' . $indicatorindex . '" class="' . $indicatoractive . '"></li>
            ';

                $indicatorindex++;
                $indicatoractive = '';

            }

            echo '</ol>';

        }

        echo '<div class="carousel-inner">';

        foreach ($items as $key => $value) {

            echo '<div class="carousel-item ' . $itemactive . '">';
            echo $value;
            echo '</div>';

            $itemactive = '';

        }
               
        echo '</div>';

        if($this->showControls) {


            echo '
            <a class="carousel-control-prev" href="#carousel' . $this->id . '" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carousel' . $this->id . '" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        ';


        }

        echo '</div>';

        $return = ob_get_contents();

        ob_end_clean();

        return $return;

    }

}

?>