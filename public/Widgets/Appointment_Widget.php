<?php

require_once(__DIR__ . '/../class-appointment-public.php');



// Creating the widget
class Appointment_Widget extends WP_Widget {

   private $appointment_public;

   public function __construct() {
      parent::__construct(
      'appointment_widget',
      'Appointment Widget',
      ['description' => 'The Widget to create an frontend view of a bookingpage.']
      );

      $this->appointment_public = new Appointment_Public('appointment','1.0.0');
   }

   // Creating widget front-end
   public function widget( $args, $instance ) {
      $selection = apply_filters( 'widget_selection', $instance['selection'] );

      // before and after widget arguments are defined by themes
      echo $args['before_widget'];
      if ( ! empty( $selection ) )
      echo $args['before_selection'];

      echo $this->appointment_public->shortcode_appointment_function(['id'=>$selection]);

      echo $args['after_selection'];

      // This is where you run the code and display the output
      echo $args['after_widget'];
   }

   // Widget Backend
   public function form( $instance ) {

      $appointments = $this->findAll();
      if ( isset( $instance[ 'selection' ] ) ) {
         $selection = $instance[ 'selection' ];
      }
      else {
         $selection = '';
      }
      // Widget admin form
      ?>
      <p>
      <label for="<?php echo $this->get_field_id( 'selection' ); ?>"><?php echo 'Buchnungstermin'; ?></label>
      <select class="widefat" id="<?php echo $this->get_field_id( 'selection' ); ?>" name="<?php echo $this->get_field_name( 'selection' ); ?>"  value="<?php echo esc_attr( $selection ); ?>" require="require" >
         <option value="">Please select</option>
         <?php
         if(count($appointments)  > 0) {
            foreach ($appointments as $key => $appointment) {
               echo '<option value="'.$appointment->id.'">'.$appointment->title.' - '.$appointment->url.'</option>';
            }
         }
         ?>
      </select>
      </p>
      <?php
      }

      // Updating widget replacing old instances with new
      public function update( $new_instance, $old_instance ) {
         $instance = array();
         $instance['selection'] = ( ! empty( $new_instance['selection'] ) ) ? strip_tags( $new_instance['selection'] ) : '';
         return $instance;
      }

      /**
       * findAll
       * returns all rows in table appointment
       * @return array
       */
      public function findAll():array {
         global $wpdb;
         $table_name = $wpdb->prefix . 'appointment';
         $res = $wpdb->get_results("SELECT * FROM $table_name");
         return $res;
      }
}
