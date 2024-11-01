<?php
/*
Plugin Name: StatsFC Table
Plugin URI: https://statsfc.com/league-table
Description: StatsFC League Table
Version: 2.2.1
Author: Will Woodward
Author URI: https://willjw.co.uk
License: GPL2
*/

/*  Copyright 2020  Will Woodward  (email : will@willjw.co.uk)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('STATSFC_TABLE_ID',      'StatsFC_Table');
define('STATSFC_TABLE_NAME',    'StatsFC Table');
define('STATSFC_TABLE_VERSION', '2.2.1');

/**
 * Adds StatsFC widget.
 */
class StatsFC_Table extends WP_Widget
{
    public $isShortcode = false;

    protected static $count = 0;

    private static $defaults = array(
        'title'       => '',
        'key'         => '',
        'competition' => '',
        'group'       => '',
        'season'      => '',
        'type'        => 'full',
        'highlight'   => '',
        'rows'        => 0,
        'date'        => '',
        'show_badges' => true,
        'show_form'   => false,
        'show_status' => false,
        'default_css' => true,
        'omit_errors' => false,
    );

    private static $whitelist = array(
        'competition',
        'group',
        'season',
        'tableType',
        'highlight',
        'rows',
        'date',
        'showBadges',
        'showForm',
        'showStatus',
        'omitErrors',
        'lang',
    );

    /**
     * Register widget with WordPress.
     */
    public function __construct()
    {
        parent::__construct(STATSFC_TABLE_ID, STATSFC_TABLE_NAME, array('description' => 'StatsFC League Table'));
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form($instance)
    {
        $instance    = wp_parse_args((array) $instance, self::$defaults);
        $title       = strip_tags($instance['title']);
        $key         = strip_tags($instance['key']);
        $competition = strip_tags($instance['competition']);
        $group       = strip_tags($instance['group']);
        $season      = strip_tags($instance['season']);
        $type        = strip_tags($instance['type']);
        $highlight   = strip_tags($instance['highlight']);
        $rows        = strip_tags($instance['rows']);
        $date        = strip_tags($instance['date']);
        $show_badges = strip_tags($instance['show_badges']);
        $show_form   = strip_tags($instance['show_form']);
        $show_status = strip_tags($instance['show_status']);
        $default_css = strip_tags($instance['default_css']);
        $omit_errors = strip_tags($instance['omit_errors']);
        ?>
        <p>
            <label>
                <?php _e('Title', STATSFC_TABLE_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Key', STATSFC_TABLE_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('key'); ?>" type="text" value="<?php echo esc_attr($key); ?>">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Competition', STATSFC_TABLE_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('competition'); ?>" type="text" value="<?php echo esc_attr($competition); ?>">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Group', STATSFC_TABLE_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('group'); ?>" type="text" value="<?php echo esc_attr($group); ?>" placeholder="Optional. E.g., A, B">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Season', STATSFC_TABLE_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('season'); ?>" type="text" value="<?php echo esc_attr($season); ?>" placeholder="e.g., 2016/2017">
            </label>
        </p>
        <p>
            <?php _e('Type', STATSFC_TABLE_ID); ?>
            <label><input name="<?php echo $this->get_field_name('type'); ?>" type="radio" value="full"<?php echo ($type == 'full' ? ' checked' : ''); ?>> Full</label>
            <label><input name="<?php echo $this->get_field_name('type'); ?>" type="radio" value="mini"<?php echo ($type == 'mini' ? ' checked' : ''); ?>> Mini</label>
        </p>
        <p>
            <label>
                <?php _e('Highlight', STATSFC_TABLE_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('highlight'); ?>" type="text" value="<?php echo esc_attr($highlight); ?>" placeholder="E.g., Liverpool, Swansea City">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Rows', STATSFC_TABLE_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('rows'); ?>" type="number" min="0" max="24" value="<?php echo esc_attr($rows); ?>" placeholder="E.g., 5, 7">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Date (YYYY-MM-DD)', STATSFC_TABLE_ID); ?>
                <input class="widefat" name="<?php echo $this->get_field_name('date'); ?>" type="text" value="<?php echo esc_attr($date); ?>" placeholder="YYYY-MM-DD">
            </label>
        </p>
        <p>
            <label>
                <?php _e('Show badges?', STATSFC_TABLE_ID); ?>
                <input type="checkbox" name="<?php echo $this->get_field_name('show_badges'); ?>"<?php echo ($show_badges == 'on' ? ' checked' : ''); ?>>
            </label>
        </p>
        <p>
            <label>
                <?php _e('Show team form?', STATSFC_TABLE_ID); ?>
                <input type="checkbox" name="<?php echo $this->get_field_name('show_form'); ?>"<?php echo ($show_form == 'on' ? ' checked' : ''); ?>>
            </label>
        </p>
        <p>
            <label>
                <?php _e('Show league position changes arrows?', STATSFC_TABLE_ID); ?>
                <input type="checkbox" name="<?php echo $this->get_field_name('show_status'); ?>"<?php echo ($show_status == 'on' ? ' checked' : ''); ?>>
            </label>
        </p>
        <p>
            <label>
                <?php _e('Use default styles?', STATSFC_TABLE_ID); ?>
                <input type="checkbox" name="<?php echo $this->get_field_name('default_css'); ?>"<?php echo ($default_css == 'on' ? ' checked' : ''); ?>>
            </label>
        </p>
        <p>
            <label>
                <?php _e('Omit error messages?', STATSFC_TABLE_ID); ?>
                <input type="checkbox" name="<?php echo $this->get_field_name('omit_errors'); ?>"<?php echo ($omit_errors == 'on' ? ' checked' : ''); ?>>
            </label>
        </p>
    <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance)
    {
        $instance                = $old_instance;
        $instance['title']       = strip_tags($new_instance['title']);
        $instance['key']         = strip_tags($new_instance['key']);
        $instance['competition'] = strip_tags($new_instance['competition']);
        $instance['group']       = strip_tags($new_instance['group']);
        $instance['season']      = strip_tags($new_instance['season']);
        $instance['type']        = strip_tags($new_instance['type']);
        $instance['highlight']   = strip_tags($new_instance['highlight']);
        $instance['rows']        = strip_tags($new_instance['rows']);
        $instance['date']        = strip_tags($new_instance['date']);
        $instance['show_badges'] = strip_tags($new_instance['show_badges']);
        $instance['show_form']   = strip_tags($new_instance['show_form']);
        $instance['show_status'] = strip_tags($new_instance['show_status']);
        $instance['default_css'] = strip_tags($new_instance['default_css']);
        $instance['omit_errors'] = strip_tags($new_instance['omit_errors']);

        return $instance;
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        extract($args);

        $title       = apply_filters('widget_title', (array_key_exists('title', $instance) ? $instance['title'] : ''));
        $unique_id   = ++static::$count;
        $key         = (array_key_exists('key', $instance) ? $instance['key'] : '');
        $referer     = (array_key_exists('HTTP_HOST', $_SERVER) ? $_SERVER['HTTP_HOST'] : '');
        $default_css = (array_key_exists('default_css', $instance) && filter_var($instance['default_css'], FILTER_VALIDATE_BOOLEAN));

        $options = array(
            'competition' => (array_key_exists('competition', $instance) ? $instance['competition'] : ''),
            'group'       => (array_key_exists('group', $instance) ? $instance['group'] : ''),
            'season'      => (array_key_exists('season', $instance) ? $instance['season'] : ''),
            'tableType'   => (array_key_exists('type', $instance) ? $instance['type'] : ''),
            'highlight'   => (array_key_exists('highlight', $instance) ? $instance['highlight'] : ''),
            'rows'        => (array_key_exists('rows', $instance) ? (int) $instance['rows'] : 0),
            'date'        => (array_key_exists('date', $instance) ? $instance['date'] : ''),
            'showBadges'  => (array_key_exists('show_badges', $instance) && filter_var($instance['show_badges'], FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false'),
            'showForm'    => (array_key_exists('show_form', $instance) && filter_var($instance['show_form'], FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false'),
            'showStatus'  => (array_key_exists('show_status', $instance) && filter_var($instance['show_status'], FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false'),
            'omitErrors'  => (array_key_exists('omit_errors', $instance) && filter_var($instance['omit_errors'], FILTER_VALIDATE_BOOLEAN) ? 'true' : 'false'),
            'lang'        => substr(get_bloginfo('language'), 0, 2),
        );

        $html = '';

        if (isset($before_widget)) {
            $html .= $before_widget;
        }

        if (isset($before_title)) {
            $html .= $before_title;
        }

        $html .= $title;

        if (isset($after_title)) {
            $html .= $after_title;
        }

        $html .= '<div id="statsfc-table-' . $unique_id . '"></div>' . PHP_EOL;

        if (isset($after_widget)) {
            $html .= $after_widget;
        }

        // Enqueue CSS
        if ($default_css) {
            wp_enqueue_style(STATSFC_TABLE_ID, plugins_url('table.css', __FILE__), null, STATSFC_TABLE_VERSION);
        }

        // Enqueue base JS
        wp_enqueue_script(STATSFC_TABLE_ID, plugins_url('table.js', __FILE__), array('jquery'), STATSFC_TABLE_VERSION, true);

        // Enqueue widget JS
        $object = 'statsfc_table_' . $unique_id;

        $script  = '<script>' . PHP_EOL;
        $script .= 'var ' . $object . ' = new StatsFC_Table(' . json_encode($key) . ');' . PHP_EOL;
        $script .= $object . '.referer = ' . json_encode($referer) . ';' . PHP_EOL;

        foreach (static::$whitelist as $parameter) {
            if (! array_key_exists($parameter, $options)) {
                continue;
            }

            $script .= $object . '.' . $parameter . ' = ' . json_encode($options[$parameter]) . ';' . PHP_EOL;
        }

        $script .= $object . '.display("statsfc-table-' . $unique_id . '");' . PHP_EOL;
        $script .= '</script>';

        add_action('wp_print_footer_scripts', function () use ($script) {
            echo $script;
        });

        if ($this->isShortcode) {
            return $html;
        } else {
            echo $html;
        }
    }

    public static function shortcode($atts)
    {
        $args = shortcode_atts(self::$defaults, $atts);

        $widget              = new self;
        $widget->isShortcode = true;

        return $widget->widget(array(), $args);
    }
}

// Register StatsFC widget
add_action('widgets_init', function () {
    register_widget(STATSFC_TABLE_ID);
});

add_shortcode('statsfc-table', STATSFC_TABLE_ID . '::shortcode');
