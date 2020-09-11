<?php


namespace Drupal\weather_service\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\weather_service\WeatherService;
use Drupal\Core\Field\FieldDefinitionInterface;

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
class WeatherFieldFormatter extends FormatterBase{

  /**
   * @var $weather_service \Drupal\weather_service\WeatherService
   */
  protected $weather_service;

  /**
   * {@inheritdoc}
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings,WeatherService $weather_service) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings);

    $this->weather_service = $weather_service;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $plugin_id,
      $plugin_definition,
      $configuration['field_definition'],
      $configuration['settings'],
      $configuration['label'],
      $configuration['view_mode'],
      $configuration['third_party_settings'],
      $container->get('weather_service.get')
    );
  }
  /**
   * {@inheritdoc}
   */
   public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {

      $cityName = $item->value;
      $weather = $this->weather_service->getForecast($cityName);

      $elements[$delta] = array(
        '#theme' => 'weather_field_formatter',
        '#weather' => $weather,
      );
    }

    return $elements;
  }

}


