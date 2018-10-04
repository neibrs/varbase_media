<?php

namespace Drupal\varbase_media\Plugin\media\Source;

use Drupal\entity_browser_generic_embed\FileInputExtensionMatchTrait;
use Drupal\entity_browser_generic_embed\InputMatchInterface;
use Drupal\media\Plugin\media\Source\Image as DrupalCoreMeidaImage;

/**
 * Input-matching version of the Varbase Media Image media source.
 */
class VarbaseMediaImage extends DrupalCoreMeidaImage implements InputMatchInterface {

  use FileInputExtensionMatchTrait;

}