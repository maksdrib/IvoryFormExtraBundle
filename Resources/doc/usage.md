# Usage

Be aware the bundle heavily relies on the form theming, so please read the 
[related documentation](http://symfony.com/doc/current/cookbook/form/form_customization.html) 
before stating.

In order to explain you how it works, we will configure all datetime form types to be converted to
a datetime picker.

## JavaScript Fragment

To attach javascript to a form type, you need to create a new datetime javascript fragment:

``` twig
{# app/Resources/Form/javascripts.html.twig #}
{% block datetime_javascript %}
    <script type="text/javascript">
        $(document).ready(function () {
            $('{{ id }}').datepicker();
        });
    </script>
{% endblock %}
```

Here, we rely on `app/Resources/Form/javascripts.html.twig` but be aware you wan put your template 
where you want in your application. 

After, you need to register this new template as form theming:

``` yaml
# app/config.yml

twig:
    form_themes:
        - '::Form/javascripts.html.twig'
```

Then, just need to render your form javascript at the bottom of the page:

``` twig
{{ form_javascript(form) }}
```

## StyleSheet Fragment

The stylehseet fragment works the same way the javascript one. So, first, create a new datetime 
stylesheet fragment:

``` twig
{# app/Resources/Form/stylesheets.html.twig #}
{% block datetime_stylesheet %}
    <style type="text/css">
        #{{ id }} {
            background-color: linen;
        }
    </style>
{% endblock %}
```

Here, we rely on `app/Resources/Form/stylesheets.html.twig` but be aware you wan put your template 
where you want in your application. 

After, you need to register this new template as form theming:

``` yaml
# app/config.yml

twig:
    form_themes:
        - '::Form/stylesheets.html.twig'
```

Then, just need to render your form stylesheet where you want in your page:

``` twig
{{ form_stylesheet(form) }}
```

The bundle also supports the PHP templating engine.
