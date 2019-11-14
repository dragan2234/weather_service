<?php


namespace Drupal\weather_service\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'weather_field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "weather_field_formatter",
 *   label = @Translation("Weather Formatter"),
 *   field_types = {
 *     "string"
 *   }
 * )
 */
class WeatherFieldFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
   public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {

      $cityName = $item->value;
      $weather = \Drupal::service('weather_service.get')->getForecast($cityName);

      $elements[$delta] = array(
        '#theme' => 'weather_field_formatter',
        '#weather' => $weather,
      );
    }

    return $elements;
  }

}


