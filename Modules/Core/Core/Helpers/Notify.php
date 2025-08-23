<?php

if (!function_exists('notify')) {
    function notify($message, array $options = []) {

		if (isset($options['icon'])) {
			$icon = "<uk-icon icon={$options['icon']} class=\"content-center mr-2\"></uk-icon>";
			$message = $icon . $message;
			unset($options['icon']);
		}

        session()->flash('notification.message', $message);
        session()->flash('notification.options', $options);
    }
}