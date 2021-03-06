<?php
/**
 * Cron
 *
 * @package     EDD
 * @subpackage  Classes/Cron
 * @copyright   Copyright (c) 2015, Pippin Williamson
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.6
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

class IRP_Cron {
	/**
	 * Get things going
	 *
	 * @since 1.6
	 * @see EDD_Cron::weekly_events()
	 */
	public function __construct() {
	}
    public function init() {
        add_filter( 'cron_schedules', array( $this, 'add_schedules'   ) );
        add_action( 'wp',             array( $this, 'schedule_Events' ) );
    }

	/**
	 * Registers new cron schedules
	 *
	 * @since 1.6
	 *
	 * @param array $schedules
	 * @return array
	 */
	public function add_schedules( $schedules = array() ) {
        global $irp;
		// Adds once weekly to the existing schedules.
		$schedules['weekly'] = array(
			'interval' => 604800,
			'display'  => $irp->Lang->L('Once Weekly')
		);

		return $schedules;
	}

	/**
	 * Schedules our events
	 *
	 * @access public
	 * @since 1.6
	 * @return void
	 */
	public function schedule_Events() {
		$this->weekly_events();
		$this->daily_events();
	}

	/**
	 * Schedule weekly events
	 *
	 * @access private
	 * @since 1.6
	 * @return void
	 */
	private function weekly_events() {
		if ( ! wp_next_scheduled( 'irp_weekly_scheduled_events' ) ) {
			wp_schedule_event( current_time( 'timestamp' ), 'weekly', 'irp_weekly_scheduled_events' );
		}
	}

	/**
	 * Schedule daily events
	 *
	 * @access private
	 * @since 1.6
	 * @return void
	 */
	private function daily_events() {
		if ( ! wp_next_scheduled( 'irp_daily_scheduled_events' ) ) {
			wp_schedule_event( current_time( 'timestamp' ), 'daily', 'irp_daily_scheduled_events' );
		}
	}
}
