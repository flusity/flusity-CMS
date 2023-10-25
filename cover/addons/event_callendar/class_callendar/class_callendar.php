<?php

class Calendar {

    private $active_year, $active_month, $active_day;
    private $events = [];
    public $naviHref = [];
    private $holidays = [];

    public function add_holidays($holidays) {
        $this->holidays = $holidays;
    }
    private function _createNavi() {
        $nextMonth = ($this->active_month == 12) ? 1 : intval($this->active_month) + 1;
        $nextYear = ($this->active_month == 12) ? intval($this->active_year) + 1 : $this->active_year;
        $preMonth = ($this->active_month == 1) ? 12 : intval($this->active_month) - 1;
        $preYear = ($this->active_month == 1) ? intval($this->active_year) - 1 : $this->active_year;
    
        $this->naviHref = [
            'nextMonth' => "javascript:updateCalendar($nextMonth, $nextYear)",
            'previousMonth' => "javascript:updateCalendar($preMonth, $preYear)"
        ];
    }

    public function __construct($date = null, $holidays = []) {
        $this->active_year = $date != null ? date('Y', strtotime($date)) : (isset($_GET['year']) ? $_GET['year'] : date("Y"));
        $this->active_month = $date != null ? date('m', strtotime($date)) : (isset($_GET['month']) ? $_GET['month'] : date("m"));
        $this->active_day = $date != null ? date('d', strtotime($date)) : (isset($_GET['day']) ? $_GET['day'] : date("d"));
        $this->holidays = $holidays;
    }

    public function add_event($id, $txt, $date, $days = 1, $color = '') {
        $color = $color ? ' ' . $color : $color;
        $this->events[] = [$id, $txt, $date, $days, $color];
    }
   
    public function getActiveDay() {
        return $this->active_day;
    }
    
    public function getActiveMonth() {
        return $this->active_month;
    }
    
    public function getActiveYear() {
        return $this->active_year;
    }
    
    public function getActiveDate() {
        return $this->active_year . '-' . str_pad($this->active_month, 2, "0", STR_PAD_LEFT) . '-' . str_pad($this->active_day, 2, "0", STR_PAD_LEFT);
    }
    public function __toString() {

        $this->_createNavi();
        
        $html = '<div class="calendar">';
        $html .= '<div class="heade">';
        $html .= '<a href="' . $this->naviHref['previousMonth'] . '" class="callendar-prev prev">&#9664;</a>'; // Pakeisti << į &#9664; (Left-pointing double angle quotation mark)
        $html .= '<a href="' . $this->naviHref['nextMonth'] . '" class="callendar-next next">&#9654;</a>'; // Pakeisti >> į &#9654; (Right-pointing double angle quotation mark)

        $lietuviski_menesiai = [
            1 => 'Sausis',
            2 => 'Vasaris',
            3 => 'Kovas',
            4 => 'Balandis',
            5 => 'Gegužė',
            6 => 'Birželis',
            7 => 'Liepa',
            8 => 'Rugpjūtis',
            9 => 'Rugsėjis',
            10 => 'Spalis',
            11 => 'Lapkritis',
            12 => 'Gruodis'
        ];

        $html .= '<div class="month-year">';
        $html .= $lietuviski_menesiai[(int)$this->active_month] . ' ' . $this->active_year;
        $html .= '</div>';

        $html .= '</div>';
        
        $days = [1 => 'Pirmadienis', 2 => 'Antradienis', 3 => 'Trečiadienis', 4 => 'Ketvirtadienis', 5 => 'Penktadienis', 6 => 'Šeštadienis', 0 => 'Sekmadienis'];
        $first_day_of_week = (date('w', strtotime($this->active_year . '-' . $this->active_month . '-1')) + 6) % 7;
        
        $html .= '<div class="days">';
        
        foreach ($days as $day) {
            $html .= '<div class="day_name">' . $day . '</div>';
        }
    
        $num_days = date('t', strtotime($this->active_year . '-' . $this->active_month));
        $num_days_last_month = date('j', strtotime('last day of previous month', strtotime($this->active_year . '-' .  $this->active_month)));
        
     
        for ($i = $first_day_of_week; $i > 0; $i--) {
            $html .= '
                <div class="day_num ignore">
                    ' . ($num_days_last_month-$i+1) . '
                </div>
            ';
        }
        for ($i = 1; $i <= $num_days; $i++) {
    
            $current_week_day = ($first_day_of_week + $i - 1) % 7;
            $selected = '';
            $day_class = '';
            
            if ($i == $this->active_day) {
                $selected = ' selected';
            }
            
            if ($current_week_day === 5 || $current_week_day === 6) {
                $day_class = ' weekend';
            }
            $current_date_str = $this->active_year . '-' . str_pad($this->active_month, 2, "0", STR_PAD_LEFT) . '-' . str_pad($i, 2, "0", STR_PAD_LEFT);
            $is_holiday = array_key_exists(date('m-d', strtotime($current_date_str)), $this->holidays);

            $is_weekend = trim($day_class) === 'weekend';
        
            $html .= '<div class="day_num' . $selected . $day_class . '" data-selected-day="'.$current_date_str.'"  >'; // dienos langelis
            $html .= '<span>' . $i . '</span>';
            
            $is_weekend = trim($day_class) === 'weekend';
            
           
            foreach ($this->events as $event) {
            if ($is_weekend || $is_holiday) {
                continue;
            }
           // var_dump($occupancy[0]);
                $event_id = $event[0];
               
                $event_start_date = strtotime($event[2]);
            
                for ($d = 0; $d <= ($event[3]-1); $d++) {
                    if (date('y-m-d', strtotime($this->active_year . '-' . $this->active_month . '-' . $i . ' -' . $d . ' day')) == date('y-m-d', strtotime($event[2]))) {
                        $current_event_date = date('Y-m-d', strtotime('+' . $d . ' day', $event_start_date));
                        
                        $is_past_date = strtotime($current_event_date) < strtotime(date('Y-m-d'));
                        
                        $event_color = $is_past_date ? 'gray' : $event[4];
            
                        $html .= '<div class="event-view event ' . $event_color . '"';
                        $html .= ' data-title="' . $event[1] . '"';
                        $html .= ' data-theme-id="' . $event_id . '"';
                        $html .= ' data-date="' . $current_event_date . '"';
                        $html .= ' data-color="' . $event_color . '">'; 
                        $html .= $event[1];
                        $html .= '</div>';
                    }
                }
            }
        
            
            $html .= '</div>';
        }
    
        $html .= '</div>';
        $html .= '</div>';
        
        return $html;
    }
}

?>
