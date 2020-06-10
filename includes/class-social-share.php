<?php if (!defined('ABSPATH')) exit;

/**
 * Print out social share icons and urls
 * 
 * @package MwbSocialShare
 * @version 0.2
 * @author Micah Kwaka
 */
class MwbSocialShare
{
  /**
   * The single instance of the class.
   *
   * @var MwbSocialShare
   * @since 0.1
   */
  protected static $_instance = null;

  /**
   * MwbSocialShare version.
   *
   * @var string
   */
  public $version = '0.0.1';

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
   * Main Instance.
   *
   * Ensures only one instance is loaded or can be loaded.
   *
   * @since 0.1
   * @static
   * @see $pe
   * @return MWBAFHubspotAdmin - Main instance.
   */
  public static function instance()
  {
    if (is_null(self::$_instance)) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }


  /**
   * Cloning is forbidden.
   *
   * @since 0.1
   */
  public function __clone()
  {
    wc_doing_it_wrong(__FUNCTION__, __('Cloning is forbidden.', 'mwb-social-share'), '0.1');
  }

  /**
   * Unserializing instances of this class is forbidden.
   *
   * @since 0.1
   */
  public function __wakeup()
  {
    wc_doing_it_wrong(__FUNCTION__, __('Unserializing instances of this class is forbidden.', 'mwb-social-share'), '0.1');
  }


  /**
   * Socialshare Constructor
   * @param int|null     $post_id
   * @param string|null  $post_url
   */
  public function __construct($post_id = null)
  {
    $this->id = $post_id ?: get_the_ID();
    $this->url = get_permalink($this->id);
    $this->thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($this->id), 'full')[0];
    $this->title = htmlspecialchars(urlencode(html_entity_decode(get_the_title($this->id), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
    
    $this->initConstants();
    $this->includes();
    $this->admin = new MwbSocialShareAdmin();

    add_shortcode('mwb_social_share', [$this, 'makeShortCode']);
    add_action('acf/init', [$this, 'getOptionsPage']);
  }

  /**
   * Define constant if not already set.
   *
   * @param string      $name  Constant name.
   * @param string|bool $value Constant value.
   */
  private function define($name, $value)
  {
    if (!defined($name)) {
      define($name, $value);
    }
  }

  private function initConstants()
  {
    $this->define('MWB_SOCIAL_SHARE_PLUGIN_URL', plugin_dir_url(MWB_SOCIAL_SHARE_PLUGIN_FILE));
    $this->define('MWB_SOCIAL_SHARE_ASSETS', MWB_SOCIAL_SHARE_PLUGIN_URL . '/assets');
    $this->define('MWB_SOCIAL_SHARE_ASSETS_VERSION', '0.1');
    $this->define('MWB_SOCIAL_SHARE_SVG', dirname(MWB_SOCIAL_SHARE_PLUGIN_FILE) . '/assets/svg');
  }

  /**
   * Get Cms options 
   * @return array  $args
   */
  protected function getCmsOptions()
  {
    return $this->admin->getAdminOptions();
  }

  /**
   * Call static method to add admin page
   */
  public function getOptionsPage()
  {
    try {
      return MwbSocialShareAdmin::addOptionsPage();
    } catch (Exception $e) {
      $e->getMessage();
      return false;
    }
  }

  /**
   * Include all our classes
   * @return [type] [description]
   */
  protected function includes()
  {
    include_once 'inc/class-admin.php';
  }

  /**
   * Prepare Social media array
   * @return array  $social_medias
   */
  private function setSocialMedias(): array
  {
    return [
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
        'url' => "whatsapp://send?text={$this->title}&{$this->url}",
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
        'url' => "http://www.linkedin.com/shareArticle?mini=true&url={$this->url}&title={$this->title}",
      ],
      'pinterest' => [
        'url' => "https://pinterest.com/pin/create/button/?url={$this->url}&amp;media={$this->thumbnail}&amp;description={$this->title}",
        'data-attribute' => addslashes('data-pin-custom="true"')
      ],
      'buffer' => [
        'url' => "https://bufferapp.com/add?url={$this->url}&amp;text={$this->title}",
      ],
      'wordpress' => [
        'url' => "https://wordpress.com/press-this.php?u={$this->url}&t={$this->title}&i={$this->thumbnail}"
      ],
      'delicious' => [
        'url' => "https://delicious.com/save?v=5&noui&jump=close&url={$this->url}&title={$this->title}"
      ]
    ];
  }

  /**
   * Build array with selected Social in cms along with the url and data attribute
   * @return array  $social
   */
  private function getSelectedSocial(): array
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
  private function getSocialBtnShape(): string
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
  private function getSocialColors(): string
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
   * Show label of social media
   * @return bool|int $include_labels true_false
   */
  private function setSocialMediaLabel(): bool
  {
    $selected_socials = $this->getCmsOptions();
    return $selected_socials['include_labels'];
  }

  /**
   * Print out social share html
   * @param string|array $title
   * @return string     $html
   */
  public function getSocialHtml($title = null): string
  {
    $classes = [];
    $styles = [];

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

    $value = shortcode_atts(array(
      'title' => 'Share this artcile:'
    ), $title);

    // For the section title
    if (!empty($title) && $title !== null) {
      $title = is_array($title) ? $title['title'] : $title;
      $title = sprintf('<h4>%s</h4>', $title);
    } else {
      $title = sprintf("<h4>%s</h4>", $value['title']);
    }

    // Return the html
    return sprintf(
      '%s
      <ul class="mwb-social-share %s" style="%s">
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
    $social_labels = $this->setSocialMediaLabel();

    foreach ($socials as $social_key => $social) {
      $classes = ["mwb-$social_key"];
      if ($social_labels) {
        $classes[] = 'with-labels';
        $labels = sprintf('<span>%s</span>', ucfirst(preg_replace("/[\-_]/", " ", $social_key)));
      } else {
        $labels = null;
      }

      $social_links[] = sprintf(
        '<li>
          <a class="%s" href="%s" %s target="blank" rel="nofollow">%s %s</a>
        </li>',
        implode(" ", $classes),
        !empty($social['url']) ? $social['url'] : false,
        !empty($social['data-attribute']) ? $social['data-attribute'] : false,
        $this->mwbSocialPartial($social_key),
        $labels
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
    $path = MWB_SOCIAL_SHARE_SVG . "/$partial.php";

    try {
      ob_start();
      include($path);
    } catch (Exception $e) {
      echo $e->getMessage();
      return;
    } finally {
      return ob_get_clean();
    }
  }

  /**
   * Whether debugging is enabled.
   */
  public function debugOn()
  {
    return (defined('WP_DEBUG') && WP_DEBUG === true);
  }

  public function makeShortCode($title = null)
  {
    $this->title = htmlspecialchars(urlencode(html_entity_decode(get_the_title($this->id), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
    $this->url = urlencode(html_entity_decode(get_permalink($this->id), ENT_COMPAT, 'UTF-8'));
    $this->thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($this->id), 'full')[0];
    return $this->getSocialHtml($title);
  }
}
