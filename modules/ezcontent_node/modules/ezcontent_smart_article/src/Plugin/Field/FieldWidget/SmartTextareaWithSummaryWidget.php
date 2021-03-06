<?php

namespace Drupal\ezcontent_smart_article\Plugin\Field\FieldWidget;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\text\Plugin\Field\FieldWidget\TextareaWithSummaryWidget;

/**
 * Plugin implementation of the 'text_textarea_with_summary' widget.
 *
 * @FieldWidget(
 *   id = "smart_text_textarea_with_summary",
 *   label = @Translation("Smart Text area with a summary"),
 *   field_types = {
 *     "smart_text_with_summary"
 *   }
 * )
 */
class SmartTextareaWithSummaryWidget extends TextareaWithSummaryWidget {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);
    $element['summary']['#prefix'] =  '<div class="visually-hidden">';
    $element['summary_container'] = [
      '#type' => 'details',
      '#title' => t('Generate Summary'),
      '#description' => t('Generate summary from text entered in body field above.'),
      '#weight' => 1,
      '#open' => FALSE,
      // Controls the HTML5 'open' attribute. Defaults to FALSE.
    ];
    $element['summary_container']['summary_area'] = [
      '#type' => 'textarea',
      '#title' => t('Summary'),
      '#default_value' => $items[$delta]->summary,
      '#rows' => $this->getSetting('summary_rows'),
      '#description' => t('Leave blank to use trimmed value of full text as the summary.'),
      '#attributes' => ['class' => ['text-summary']],
      '#prefix' => '<div class="text-summary-wrapper">',
      '#suffix' => '</div>',
    ];
    $element['summary_container']['summary_type'] = [
      '#type' => 'radios',
      '#title' => t("Summary type"),
      '#options' => [
        'abstractive' => 'Abstractive',
        'extractive' => 'Extractive',
      ],
      '#default_value' => 'abstractive',
    ];
    $element['summary_container']['number_of_sentences'] = [
      '#type' => 'number',
      '#title' => t("Number of sentences"),
      '#min' => 1,
      '#default_value' => 5,
    ];
    $element['summary_container']['generate_smart_summary'] = [
      '#type' => 'button',
      '#name' => 'generate_smart_summary',
      '#value' => t('Generate Smart Summary'),
    ];
    return $element;
  }

}
