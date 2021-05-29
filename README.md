# PHP Blog
Clean PHP Open Source without framework

## Future
 - Fasted Route System
 - Template System
 - Language System
 - Theme System

## Install
Coming soon

### Template Engine Usage
### Extends / Blocks

``{% (extends|include) layout %}``

``{% yield block_name %}``

``{% block name %} {% endblock; %}``

### PHP Tags

`{% php code %}`

`{% foreach($item as $key): %} debug {% endforeach; %}`

`{% if($item): %} debug {% endif; %}`

`{% if($item): %} debug {% else/elseif: %} {% endif; %}`

`{% var_dump($func) %}`

`{{ $func }} # echo func`

`{{{ $func }}} # stripes echos`

### URL/Lang Support
    
`{{ url_to('url') }}`

`{{ lang('lang_item') }}`

`{{ site_url() }}`

`{{ THEMES_PATH }}`

`{{ page_title }}`

`{{ url_from('url', [array]) }}`
    
### Parts Includes
`
{% parts part_name %}
`

## License
 - MIT

## Demo & Preview
![Main Page](https://github.com/Staark94/php-blog/blob/main/demo/Blog.PNG)
![Main Page](https://github.com/Staark94/php-blog/blob/main/demo/Capture2.PNG)
