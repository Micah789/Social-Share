<?php
/**
 * Print out social share icons and urls
 * 
 * @package MwbSocialShare
 * @version 0.2
 * @author Micah Kwaka
 * TODO: add to shortcode
 * TODO: make it into a plugin after review with dom
 */

if (!defined('ABSPATH')) exit;

class MwbSocialShare
{

  /**
   * @var int
   */
  private $id;

  /**
   * @var string
   */
  private $url;

  /**
   * @var string
   */
  private $title;

  /**
   * @var array|string
   */
  private $thumbnail;

  /**
   * Socialshare Constructor
   * @param int|null     $post_id
   * @param string|null  $post_url
   */
  public function __construct($post_id = null, $post_url = null)
  {
    $this->id = $post_id ?? get_the_ID();
    $this->url = $post_url ?? get_permalink();
    $this->thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($this->id), 'full')[0];
    $this->title = htmlspecialchars(urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
    define("SOCIALSHAREPATH", get_stylesheet_directory_uri() . "/includes/social-share");
  }

  /**
   * Get Cms options 
   * @return array  $args
   */
  protected function getCmsOptions(): array
  {
    return [
      'social_share_selection'       => get_field('social_share_selection', 'option'),
      'include_button_shape'         => get_field('include_button_shape', 'option'),
      'social_share_shape'           => get_field('social_share_shape', 'option'),
      'color_option'                 => get_field('color_option', 'option'),
      'social_button_color'          => get_field('social_button_color', 'option')
    ];
  }

  /**
   * Prepare Social media array
   * @return array  $social_medias
   */
  private function setSocialMedias(): array
  {
    $social_medias = [
      'twitter' => [
        'url' => "https://twitter.com/intent/tweet?text={$this->title}&amp;url={$this->url}",
      ],
      'facebook' => [
        'url' => "https://www.facebook.com/sharer.php?u={$this->url}",
      ],
      'skype' => [
        'url' => "https://web.skype.com/share?url={$this->url}&text={$this->title}",
      ],
      'google-plus' => [
        'url' => "https://plus.google.com/share?url={$this->url}"
      ],
      'reddit' => [
        'url' => "https://reddit.com/submit?url={$this->url}&amp;text={$this->title}"
      ],
      'vk' => [
        'url' => "https://vk.com/share.php?url={$this->url}&title={$this->title}&image={$this->thumbnail}",
      ],
      'whatsapp' => [
        'url' => "whatsapp://send?text={$this->title}-{$this->url}",
        'data-attribute' => 'data-action="share/whatsapp/share"'
      ],
      'blogger' => [
        'url' => "https://www.blogger.com/blog-this.g?u={$this->url}&n={$this->title}",
      ],
      'tumblr' => [
        'url' => "https://www.tumblr.com/share/link?url={$this->url}&name={$this->title}",
      ],
      'pocket' => [
        'url' => "https://getpocket.com/save?url={$this->url}&title={$this->title}",
      ],
      'evernote' => [
        'url' => "https://www.evernote.com/clip.action?url={$this->url}&title={$this->title}",
      ],
      'email' => [
        'url' => "mailto:?subject={$this->title}&body=Check out this article: {$this->url}",
        'data-attribute' => addslashes('title="Share by Email"'),
      ],
      'linkedin' => [
        'url' => "http://www.linkedin.com/shareArticle?url={$this->url}&title={$this->title}",
      ],
      'pinterest' => [
        'url' => "https://pinterest.com/pin/create/button/?url={$this->url}&amp;media={$this->thumbnail}&amp;description={$this->title}",
        'data-attribute' => addslashes('data-pin-custom="true"')
      ],
      'buffer' => [
        'url' => "https://bufferapp.com/add?url={$this->url}&amp;text={$this->title}",
      ]
    ];

    ksort($social_medias);

    return $social_medias;
  }

  /**
   * Build array with selected Social in cms along with the url and data attribute
   * @return array  $social
   */
  public function getSelectedSocial(): array
  {
    $socials = [];

    $selected_socials = $this->getCmsOptions();
    $socials_details = $this->setSocialMedias();

    if (!empty($selected_socials['social_share_selection'])) {
      foreach ($selected_socials['social_share_selection'] as $social_selection) {
        $socials[$social_selection] = $socials_details[$social_selection];
      }
    } else {
      foreach ($socials_details as $social_index => $socials_detail) {
        $socials[$social_index] = $socials_detail;
      }
    }

    return $socials;
  }

  /** 
   * Get social button shape
   * @return string $selected_socials
   */
  public function getSocialBtnShape(): string
  {
    $selected_socials = $this->getCmsOptions();
    if ($selected_socials['include_button_shape'] && !empty($selected_socials['social_share_shape'])) {
      return $selected_socials['social_share_shape'];
    } else {
      return false;
    }
  }

  /**
   * Get social color option
   * @return string $color
   */
  public function getSocialColors(): string
  {
    $selected_socials = $this->getCmsOptions();

    switch ($selected_socials['color_option']) {
      case 'custom':
        $color = $selected_socials['social_button_color'];
        break;

      default:
      case 'default':
        $color = 'default';
        break;
    }

    return $color;
  }


  /**
   * Print out social share html
   * @param string|null $title
   * @return string     $html
   */
  public function getSocialHtml(string $title = null): string
  {
    $classes = [];
    $styles = [];

    $this->mwbSocialAssets();

    // gather all the configuratiions
    if (!empty($this->getSocialBtnShape()) && $this->getSocialBtnShape() !== false) {
      $classes[] = $this->getSocialBtnShape();
    }

    if (!empty($this->getSocialColors())) {
      if ($this->getSocialColors() == 'default') {
        $classes[] = 'default-social-color';
      } else {
        $styles[] = 'fill:' . $this->getSocialColors() . ';';
      }
    }

    // For the section title
    if(!empty($title) && $title !== null) {
      $title = sprintf('<h4>%s</h4>', $title);
    } else {
      $title = "<h4>Share this article:</h4>";
    }

    // Return the html
    return sprintf(
      '%s
      <ul class="mwb-social %s" style="%s">
        %s
      </ul>',
      $title,
      implode(" ", $classes),
      implode(" ", $styles),
      implode(" ", $this->getSocialLinks())
    );
  }

  /**
   * get social links with data attr and return to main html method
   * @version 0.3
   * @return array $social_links
   */
  private function getSocialLinks(): array
  {
    $socials = $this->getSelectedSocial();
    $social_links = [];

    foreach ($socials as $social_key => $social) {
      $social_links[] = sprintf(
        '<li>
          <a class="mwb-%s" href="%s" %s target="blank" rel="nofollow">%s</a>
        </li>',
        $social_key,
        !empty($social['url']) ? $social['url'] : false,
        !empty($social['data-attribute']) ? $social['data-attribute'] : false,
        $this->mwbSocialPartial("assets/svg/{$social_key}")
      );
    }

    return $social_links;
  }

  /**
   * @param  String $partial path to file within the theme 'includes' directory
   * @return [type] [description]
   */
  private function mwbSocialPartial(string $partial)
  {
    $path = "includes/social-share/$partial.php";

    if (!$template = locate_template($path, false, false)) {
      $message = "Partial doesn't exist at path '{$path}'";
      echo "<div class=\"grid-container\" style=\"margin: 60px auto;\"><code>{$message}</code></div>";
      return;
    }

    ob_start();
    include($template);
    return ob_get_clean();
  }

  /**
   * Enquene css file
   */
  private function mwbSocialAssets()
  {
    wp_enqueue_style('mwv-social-share-css', SOCIALSHAREPATH . '/assets/css/style.css', [], '0.0.5');
  }
}
