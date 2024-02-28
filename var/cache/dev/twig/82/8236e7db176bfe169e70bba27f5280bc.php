<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* @WebProfiler/Collector/mailer.html.twig */
class __TwigTemplate_6d21b085fda36b9588551b24546a0083 extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'stylesheets' => [$this, 'block_stylesheets'],
            'javascripts' => [$this, 'block_javascripts'],
            'toolbar' => [$this, 'block_toolbar'],
            'menu' => [$this, 'block_menu'],
            'panel' => [$this, 'block_panel'],
        ];
        $macros["_self"] = $this->macros["_self"] = $this;
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "@WebProfiler/Profiler/layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/mailer.html.twig"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "template", "@WebProfiler/Collector/mailer.html.twig"));

        $this->parent = $this->loadTemplate("@WebProfiler/Profiler/layout.html.twig", "@WebProfiler/Collector/mailer.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

    }

    // line 3
    public function block_stylesheets($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "stylesheets"));

        // line 4
        echo "    ";
        $this->displayParentBlock("stylesheets", $context, $blocks);
        echo "

    <style>
        :root {
            --mailer-email-table-wrapper-background: var(--gray-100);
            --mailer-email-table-active-row-background: #dbeafe;
            --mailer-email-table-active-row-color: var(--color-text);
        }
        .theme-dark {
            --mailer-email-table-wrapper-background: var(--gray-900);
            --mailer-email-table-active-row-background: var(--gray-300);
            --mailer-email-table-active-row-color: var(--gray-800);
        }

        .mailer-email-summary-table-wrapper {
            background: var(--mailer-email-table-wrapper-background);
            border-bottom: 4px double var(--table-border-color);
            border-radius: inherit;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            margin: 0 -9px 10px -9px;
            padding-bottom: 10px;
            transform: translateY(-9px);
            max-height: 265px;
            overflow-y: auto;
        }
        .mailer-email-summary-table,
        .mailer-email-summary-table tr,
        .mailer-email-summary-table td {
            border: 0;
            border-radius: inherit;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            box-shadow: none;
        }
        .mailer-email-summary-table th {
            color: var(--color-muted);
            font-size: 13px;
            padding: 4px 10px;
        }
        .mailer-email-summary-table tr td,
        .mailer-email-summary-table tr:last-of-type td {
            border: solid var(--table-border-color);
            border-width: 1px 0;
        }
        .mailer-email-summary-table-row {
            margin: 5px 0;
        }
        .mailer-email-summary-table-row:hover {
            cursor: pointer;
        }
        .mailer-email-summary-table-row.active {
            background: var(--mailer-email-table-active-row-background);
            color: var(--mailer-email-table-active-row-color);
        }
        .mailer-email-summary-table-row td {
            font-family: var(--font-family-system);
            font-size: inherit;
        }
        .mailer-email-details {
            display: none;
        }
        .mailer-email-details.active {
            display: block;
        }
        .mailer-transport-information {
            border-bottom: 1px solid var(--form-input-border-color);
            padding-bottom: 5px;
            font-size: var(--font-size-body);
            margin: 5px 0 10px 5px;
        }
        .mailer-transport-information .badge {
            font-size: inherit;
            font-weight: inherit;
        }
        .mailer-message-subject {
            font-size: 21px;
            font-weight: bold;
            margin: 5px;
        }
        .mailer-message-headers {
            margin-bottom: 10px;
        }
        .mailer-message-headers p {
            font-size: var(--font-size-body);
            margin: 2px 5px;
        }
        .mailer-message-header-secondary {
            color: var(--color-muted);
        }
        .mailer-message-attachments-title {
            align-items: center;
            display: flex;
            font-size: var(--font-size-body);
            font-weight: 600;
            margin-bottom: 10px;
        }
        .mailer-message-attachments-title svg {
            color: var(--color-muted);
            margin-right: 5px;
            height: 18px;
            width: 18px;
        }
        .mailer-message-attachments-title span {
            font-weight: normal;
            margin-left: 4px;
        }
        .mailer-message-attachments-list {
            list-style: none;
            margin: 0 0 5px 20px;
            padding: 0;
        }
        .mailer-message-attachments-list li {
            align-items: center;
            display: flex;
        }
        .mailer-message-attachments-list li svg {
            margin-right: 5px;
            height: 18px;
            width: 18px;
        }
        .mailer-message-attachments-list li a {
            margin-left: 5px;
        }
        .mailer-email-body {
            margin: 0;
            padding: 6px 8px;
        }
        .mailer-empty-email-body {
            background-image: url(\"data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' stroke='%23e5e5e5' stroke-width='4' stroke-dasharray='6%2c 14' stroke-dashoffset='0' stroke-linecap='square'/%3e%3c/svg%3e\");
            border-radius: 6px;
            color: var(--color-muted);
            margin: 1em 0 0;
            padding: .5em 1em;
        }
        .theme-dark .mailer-empty-email-body {
            background-image: url(\"data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' stroke='%23737373' stroke-width='4' stroke-dasharray='6%2c 14' stroke-dashoffset='0' stroke-linecap='square'/%3e%3c/svg%3e\");
        }
        .mailer-empty-email-body p {
            font-size: var(--font-size-body);
            margin: 0;
            padding: 0.5em 0;
        }

        .mailer-message-download-raw {
            align-items: center;
            display: flex;
            padding: 5px 0 0 5px;
        }
        .mailer-message-download-raw svg {
            height: 18px;
            width: 18px;
            margin-right: 3px;
        }
    </style>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

    }

    // line 161
    public function block_javascripts($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "javascripts"));

        // line 162
        echo "    ";
        $this->displayParentBlock("javascripts", $context, $blocks);
        echo "

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            new SymfonyProfilerMailerPanel();
        });

        class SymfonyProfilerMailerPanel {
            constructor() {
                this.#initializeEmailsTable();
            }

            #initializeEmailsTable() {
                const emailRows = document.querySelectorAll('.mailer-email-summary-table-row');

                emailRows.forEach((emailRow) => {
                    emailRow.addEventListener('click', () => {
                        emailRows.forEach((row) => row.classList.remove('active'));
                        emailRow.classList.add('active');

                        document.querySelectorAll('.mailer-email-details').forEach((emailDetails) => emailDetails.style.display = 'none');
                        document.querySelector(emailRow.getAttribute('data-target')).style.display = 'block';
                    });
                });
            }
        }
    </script>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

    }

    // line 191
    public function block_toolbar($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "toolbar"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "toolbar"));

        // line 192
        echo "    ";
        $context["events"] = twig_get_attribute($this->env, $this->source, (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 192, $this->source); })()), "events", [], "any", false, false, false, 192);
        // line 193
        echo "
    ";
        // line 194
        if (twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["events"]) || array_key_exists("events", $context) ? $context["events"] : (function () { throw new RuntimeError('Variable "events" does not exist.', 194, $this->source); })()), "messages", [], "any", false, false, false, 194))) {
            // line 195
            echo "        ";
            ob_start();
            // line 196
            echo "            ";
            echo twig_source($this->env, "@WebProfiler/Icon/mailer.svg");
            echo "
            <span class=\"sf-toolbar-value\">";
            // line 197
            echo twig_escape_filter($this->env, twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["events"]) || array_key_exists("events", $context) ? $context["events"] : (function () { throw new RuntimeError('Variable "events" does not exist.', 197, $this->source); })()), "messages", [], "any", false, false, false, 197)), "html", null, true);
            echo "</span>
        ";
            $context["icon"] = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
            // line 199
            echo "
        ";
            // line 200
            ob_start();
            // line 201
            echo "            <div class=\"sf-toolbar-info-piece\">
                <b>Queued messages</b>
                <span class=\"sf-toolbar-status\">";
            // line 203
            echo twig_escape_filter($this->env, twig_length_filter($this->env, twig_array_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["events"]) || array_key_exists("events", $context) ? $context["events"] : (function () { throw new RuntimeError('Variable "events" does not exist.', 203, $this->source); })()), "events", [], "any", false, false, false, 203), function ($__e__) use ($context, $macros) { $context["e"] = $__e__; return twig_get_attribute($this->env, $this->source, (isset($context["e"]) || array_key_exists("e", $context) ? $context["e"] : (function () { throw new RuntimeError('Variable "e" does not exist.', 203, $this->source); })()), "isQueued", [], "method", false, false, false, 203); })), "html", null, true);
            echo "</span>
            </div>
            <div class=\"sf-toolbar-info-piece\">
                <b>Sent messages</b>
                <span class=\"sf-toolbar-status\">";
            // line 207
            echo twig_escape_filter($this->env, twig_length_filter($this->env, twig_array_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["events"]) || array_key_exists("events", $context) ? $context["events"] : (function () { throw new RuntimeError('Variable "events" does not exist.', 207, $this->source); })()), "events", [], "any", false, false, false, 207), function ($__e__) use ($context, $macros) { $context["e"] = $__e__; return  !twig_get_attribute($this->env, $this->source, (isset($context["e"]) || array_key_exists("e", $context) ? $context["e"] : (function () { throw new RuntimeError('Variable "e" does not exist.', 207, $this->source); })()), "isQueued", [], "method", false, false, false, 207); })), "html", null, true);
            echo "</span>
            </div>
        ";
            $context["text"] = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
            // line 210
            echo "
        ";
            // line 211
            echo twig_include($this->env, $context, "@WebProfiler/Profiler/toolbar_item.html.twig", ["link" => (isset($context["profiler_url"]) || array_key_exists("profiler_url", $context) ? $context["profiler_url"] : (function () { throw new RuntimeError('Variable "profiler_url" does not exist.', 211, $this->source); })())]);
            echo "
    ";
        }
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

    }

    // line 215
    public function block_menu($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "menu"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "menu"));

        // line 216
        echo "    ";
        $context["events"] = twig_get_attribute($this->env, $this->source, (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 216, $this->source); })()), "events", [], "any", false, false, false, 216);
        // line 217
        echo "
    <span class=\"label ";
        // line 218
        echo ((twig_test_empty(twig_get_attribute($this->env, $this->source, (isset($context["events"]) || array_key_exists("events", $context) ? $context["events"] : (function () { throw new RuntimeError('Variable "events" does not exist.', 218, $this->source); })()), "messages", [], "any", false, false, false, 218))) ? ("disabled") : (""));
        echo "\">
        <span class=\"icon\">";
        // line 219
        echo twig_source($this->env, "@WebProfiler/Icon/mailer.svg");
        echo "</span>

        <strong>Emails</strong>
        ";
        // line 222
        if ((twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["events"]) || array_key_exists("events", $context) ? $context["events"] : (function () { throw new RuntimeError('Variable "events" does not exist.', 222, $this->source); })()), "messages", [], "any", false, false, false, 222)) > 0)) {
            // line 223
            echo "            <span class=\"count\">
                <span>";
            // line 224
            echo twig_escape_filter($this->env, twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["events"]) || array_key_exists("events", $context) ? $context["events"] : (function () { throw new RuntimeError('Variable "events" does not exist.', 224, $this->source); })()), "messages", [], "any", false, false, false, 224)), "html", null, true);
            echo "</span>
            </span>
        ";
        }
        // line 227
        echo "    </span>
";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

    }

    // line 230
    public function block_panel($context, array $blocks = [])
    {
        $macros = $this->macros;
        $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "panel"));

        $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "block", "panel"));

        // line 231
        echo "    ";
        $context["events"] = twig_get_attribute($this->env, $this->source, (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 231, $this->source); })()), "events", [], "any", false, false, false, 231);
        // line 232
        echo "    <h2>Emails</h2>

    ";
        // line 234
        if ( !twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["events"]) || array_key_exists("events", $context) ? $context["events"] : (function () { throw new RuntimeError('Variable "events" does not exist.', 234, $this->source); })()), "messages", [], "any", false, false, false, 234))) {
            // line 235
            echo "        <div class=\"empty empty-panel\">
            <p>No emails were sent.</p>
        </div>
    ";
        } else {
            // line 239
            echo "        <div class=\"metrics\">
            <div class=\"metric-group\">
                <div class=\"metric\">
                    <span class=\"value\">";
            // line 242
            echo twig_escape_filter($this->env, twig_length_filter($this->env, twig_array_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["events"]) || array_key_exists("events", $context) ? $context["events"] : (function () { throw new RuntimeError('Variable "events" does not exist.', 242, $this->source); })()), "events", [], "any", false, false, false, 242), function ($__e__) use ($context, $macros) { $context["e"] = $__e__; return twig_get_attribute($this->env, $this->source, (isset($context["e"]) || array_key_exists("e", $context) ? $context["e"] : (function () { throw new RuntimeError('Variable "e" does not exist.', 242, $this->source); })()), "isQueued", [], "method", false, false, false, 242); })), "html", null, true);
            echo "</span>
                    <span class=\"label\">Queued</span>
                </div>

                <div class=\"metric\">
                    <span class=\"value\">";
            // line 247
            echo twig_escape_filter($this->env, twig_length_filter($this->env, twig_array_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["events"]) || array_key_exists("events", $context) ? $context["events"] : (function () { throw new RuntimeError('Variable "events" does not exist.', 247, $this->source); })()), "events", [], "any", false, false, false, 247), function ($__e__) use ($context, $macros) { $context["e"] = $__e__; return  !twig_get_attribute($this->env, $this->source, (isset($context["e"]) || array_key_exists("e", $context) ? $context["e"] : (function () { throw new RuntimeError('Variable "e" does not exist.', 247, $this->source); })()), "isQueued", [], "method", false, false, false, 247); })), "html", null, true);
            echo "</span>
                    <span class=\"label\">Sent</span>
                </div>
            </div>
        </div>
    ";
        }
        // line 253
        echo "
    ";
        // line 254
        if ((twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["events"]) || array_key_exists("events", $context) ? $context["events"] : (function () { throw new RuntimeError('Variable "events" does not exist.', 254, $this->source); })()), "transports", [], "any", false, false, false, 254)) > 1)) {
            // line 255
            echo "        ";
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["events"]) || array_key_exists("events", $context) ? $context["events"] : (function () { throw new RuntimeError('Variable "events" does not exist.', 255, $this->source); })()), "transports", [], "any", false, false, false, 255));
            foreach ($context['_seq'] as $context["_key"] => $context["transport"]) {
                // line 256
                echo "            <h2><code>";
                echo twig_escape_filter($this->env, $context["transport"], "html", null, true);
                echo "</code> transport</h2>
            ";
                // line 257
                echo twig_call_macro($macros["_self"], "macro_render_transport_details", [(isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 257, $this->source); })()), $context["transport"]], 257, $context, $this->getSourceContext());
                echo "
        ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['transport'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 259
            echo "    ";
        } elseif ( !twig_test_empty(twig_get_attribute($this->env, $this->source, (isset($context["events"]) || array_key_exists("events", $context) ? $context["events"] : (function () { throw new RuntimeError('Variable "events" does not exist.', 259, $this->source); })()), "transports", [], "any", false, false, false, 259))) {
            // line 260
            echo "        ";
            echo twig_call_macro($macros["_self"], "macro_render_transport_details", [(isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 260, $this->source); })()), twig_first($this->env, twig_get_attribute($this->env, $this->source, (isset($context["events"]) || array_key_exists("events", $context) ? $context["events"] : (function () { throw new RuntimeError('Variable "events" does not exist.', 260, $this->source); })()), "transports", [], "any", false, false, false, 260)), true], 260, $context, $this->getSourceContext());
            echo "
    ";
        }
        // line 262
        echo "
    ";
        // line 317
        echo "
    ";
        // line 501
        echo "
    ";
        
        $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

        
        $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);

    }

    // line 263
    public function macro_render_transport_details($__collector__ = null, $__transport__ = null, $__show_transport_name__ = false, ...$__varargs__)
    {
        $macros = $this->macros;
        $context = $this->env->mergeGlobals([
            "collector" => $__collector__,
            "transport" => $__transport__,
            "show_transport_name" => $__show_transport_name__,
            "varargs" => $__varargs__,
        ]);

        $blocks = [];

        ob_start();
        try {
            $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
            $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "macro", "render_transport_details"));

            $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
            $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "macro", "render_transport_details"));

            // line 264
            echo "        <div class=\"card\">
            ";
            // line 265
            $context["num_emails"] = twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 265, $this->source); })()), "events", [], "any", false, false, false, 265), "events", [(isset($context["transport"]) || array_key_exists("transport", $context) ? $context["transport"] : (function () { throw new RuntimeError('Variable "transport" does not exist.', 265, $this->source); })())], "method", false, false, false, 265));
            // line 266
            echo "            ";
            if (((isset($context["num_emails"]) || array_key_exists("num_emails", $context) ? $context["num_emails"] : (function () { throw new RuntimeError('Variable "num_emails" does not exist.', 266, $this->source); })()) > 1)) {
                // line 267
                echo "                <div class=\"mailer-email-summary-table-wrapper\">
                    <table class=\"mailer-email-summary-table\">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Subject</th>
                                <th>To</th>
                                <th class=\"visually-hidden\">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            ";
                // line 278
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 278, $this->source); })()), "events", [], "any", false, false, false, 278), "events", [(isset($context["transport"]) || array_key_exists("transport", $context) ? $context["transport"] : (function () { throw new RuntimeError('Variable "transport" does not exist.', 278, $this->source); })())], "method", false, false, false, 278));
                $context['loop'] = [
                  'parent' => $context['_parent'],
                  'index0' => 0,
                  'index'  => 1,
                  'first'  => true,
                ];
                if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
                    $length = count($context['_seq']);
                    $context['loop']['revindex0'] = $length - 1;
                    $context['loop']['revindex'] = $length;
                    $context['loop']['length'] = $length;
                    $context['loop']['last'] = 1 === $length;
                }
                foreach ($context['_seq'] as $context["_key"] => $context["event"]) {
                    // line 279
                    echo "                                <tr class=\"mailer-email-summary-table-row ";
                    echo ((twig_get_attribute($this->env, $this->source, $context["loop"], "first", [], "any", false, false, false, 279)) ? ("active") : (""));
                    echo "\" data-target=\"#email-";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, false, 279), "html", null, true);
                    echo "\">
                                    <td>";
                    // line 280
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, false, 280), "html", null, true);
                    echo "</td>
                                    <td>
                                        ";
                    // line 282
                    if (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["event"], "message", [], "any", false, true, false, 282), "subject", [], "any", true, true, false, 282)) {
                        // line 283
                        echo "                                            ";
                        (((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["event"], "message", [], "any", false, true, false, 283), "getSubject", [], "method", true, true, false, 283) &&  !(null === twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["event"], "message", [], "any", false, true, false, 283), "getSubject", [], "method", false, false, false, 283)))) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["event"], "message", [], "any", false, true, false, 283), "getSubject", [], "method", false, false, false, 283), "html", null, true))) : (print ("(No subject)")));
                        echo "
                                        ";
                    } elseif (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source,                     // line 284
$context["event"], "message", [], "any", false, false, false, 284), "headers", [], "any", false, false, false, 284), "has", ["subject"], "method", false, false, false, 284)) {
                        // line 285
                        echo "                                            ";
                        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["event"], "message", [], "any", false, true, false, 285), "headers", [], "any", false, true, false, 285), "get", ["subject"], "method", false, true, false, 285), "bodyAsString", [], "method", true, true, false, 285)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["event"], "message", [], "any", false, true, false, 285), "headers", [], "any", false, true, false, 285), "get", ["subject"], "method", false, true, false, 285), "bodyAsString", [], "method", false, false, false, 285), "(No subject)")) : ("(No subject)")), "html", null, true);
                        echo "
                                        ";
                    } else {
                        // line 287
                        echo "                                            (No subject)
                                        ";
                    }
                    // line 289
                    echo "                                    </td>
                                    <td>
                                        ";
                    // line 291
                    if (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["event"], "message", [], "any", false, true, false, 291), "to", [], "any", true, true, false, 291)) {
                        // line 292
                        echo "                                            ";
                        echo twig_escape_filter($this->env, _twig_default_filter(twig_join_filter(twig_array_map($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["event"], "message", [], "any", false, false, false, 292), "getTo", [], "method", false, false, false, 292), function ($__addr__) use ($context, $macros) { $context["addr"] = $__addr__; return twig_get_attribute($this->env, $this->source, (isset($context["addr"]) || array_key_exists("addr", $context) ? $context["addr"] : (function () { throw new RuntimeError('Variable "addr" does not exist.', 292, $this->source); })()), "toString", [], "method", false, false, false, 292); }), ", "), "(empty)"), "html", null, true);
                        echo "
                                        ";
                    } elseif (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source,                     // line 293
$context["event"], "message", [], "any", false, false, false, 293), "headers", [], "any", false, false, false, 293), "has", ["to"], "method", false, false, false, 293)) {
                        // line 294
                        echo "                                            ";
                        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["event"], "message", [], "any", false, true, false, 294), "headers", [], "any", false, true, false, 294), "get", ["to"], "method", false, true, false, 294), "bodyAsString", [], "method", true, true, false, 294)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, $context["event"], "message", [], "any", false, true, false, 294), "headers", [], "any", false, true, false, 294), "get", ["to"], "method", false, true, false, 294), "bodyAsString", [], "method", false, false, false, 294), "(empty)")) : ("(empty)")), "html", null, true);
                        echo "
                                        ";
                    } else {
                        // line 296
                        echo "                                            (empty)
                                        ";
                    }
                    // line 298
                    echo "                                    </td>
                                    <td class=\"visually-hidden\"><button class=\"mailer-email-summary-table-row-button\" data-target=\"#email-";
                    // line 299
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, false, 299), "html", null, true);
                    echo "\">View email details</button></td>
                                </tr>
                            ";
                    ++$context['loop']['index0'];
                    ++$context['loop']['index'];
                    $context['loop']['first'] = false;
                    if (isset($context['loop']['length'])) {
                        --$context['loop']['revindex0'];
                        --$context['loop']['revindex'];
                        $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                    }
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['event'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 302
                echo "                        </tbody>
                    </table>
                </div>

                ";
                // line 306
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 306, $this->source); })()), "events", [], "any", false, false, false, 306), "events", [(isset($context["transport"]) || array_key_exists("transport", $context) ? $context["transport"] : (function () { throw new RuntimeError('Variable "transport" does not exist.', 306, $this->source); })())], "method", false, false, false, 306));
                $context['loop'] = [
                  'parent' => $context['_parent'],
                  'index0' => 0,
                  'index'  => 1,
                  'first'  => true,
                ];
                if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
                    $length = count($context['_seq']);
                    $context['loop']['revindex0'] = $length - 1;
                    $context['loop']['revindex'] = $length;
                    $context['loop']['length'] = $length;
                    $context['loop']['last'] = 1 === $length;
                }
                foreach ($context['_seq'] as $context["_key"] => $context["event"]) {
                    // line 307
                    echo "                    <div class=\"mailer-email-details ";
                    echo ((twig_get_attribute($this->env, $this->source, $context["loop"], "first", [], "any", false, false, false, 307)) ? ("active") : (""));
                    echo "\" id=\"email-";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, false, 307), "html", null, true);
                    echo "\">
                        ";
                    // line 308
                    echo twig_call_macro($macros["_self"], "macro_render_email_details", [(isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 308, $this->source); })()), (isset($context["transport"]) || array_key_exists("transport", $context) ? $context["transport"] : (function () { throw new RuntimeError('Variable "transport" does not exist.', 308, $this->source); })()), twig_get_attribute($this->env, $this->source, $context["event"], "message", [], "any", false, false, false, 308), twig_get_attribute($this->env, $this->source, $context["event"], "isQueued", [], "any", false, false, false, 308), (isset($context["show_transport_name"]) || array_key_exists("show_transport_name", $context) ? $context["show_transport_name"] : (function () { throw new RuntimeError('Variable "show_transport_name" does not exist.', 308, $this->source); })())], 308, $context, $this->getSourceContext());
                    echo "
                    </div>
                ";
                    ++$context['loop']['index0'];
                    ++$context['loop']['index'];
                    $context['loop']['first'] = false;
                    if (isset($context['loop']['length'])) {
                        --$context['loop']['revindex0'];
                        --$context['loop']['revindex'];
                        $context['loop']['last'] = 0 === $context['loop']['revindex0'];
                    }
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['event'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 311
                echo "            ";
            } else {
                // line 312
                echo "                ";
                $context["event"] = twig_first($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 312, $this->source); })()), "events", [], "any", false, false, false, 312), "events", [(isset($context["transport"]) || array_key_exists("transport", $context) ? $context["transport"] : (function () { throw new RuntimeError('Variable "transport" does not exist.', 312, $this->source); })())], "method", false, false, false, 312));
                // line 313
                echo "                ";
                echo twig_call_macro($macros["_self"], "macro_render_email_details", [(isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 313, $this->source); })()), (isset($context["transport"]) || array_key_exists("transport", $context) ? $context["transport"] : (function () { throw new RuntimeError('Variable "transport" does not exist.', 313, $this->source); })()), twig_get_attribute($this->env, $this->source, (isset($context["event"]) || array_key_exists("event", $context) ? $context["event"] : (function () { throw new RuntimeError('Variable "event" does not exist.', 313, $this->source); })()), "message", [], "any", false, false, false, 313), twig_get_attribute($this->env, $this->source, (isset($context["event"]) || array_key_exists("event", $context) ? $context["event"] : (function () { throw new RuntimeError('Variable "event" does not exist.', 313, $this->source); })()), "isQueued", [], "any", false, false, false, 313), (isset($context["show_transport_name"]) || array_key_exists("show_transport_name", $context) ? $context["show_transport_name"] : (function () { throw new RuntimeError('Variable "show_transport_name" does not exist.', 313, $this->source); })())], 313, $context, $this->getSourceContext());
                echo "
            ";
            }
            // line 315
            echo "        </div>
    ";
            
            $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

            
            $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);


            return ('' === $tmp = ob_get_contents()) ? '' : new Markup($tmp, $this->env->getCharset());
        } finally {
            ob_end_clean();
        }
    }

    // line 318
    public function macro_render_email_details($__collector__ = null, $__transport__ = null, $__message__ = null, $__message_is_queued__ = null, $__show_transport_name__ = false, ...$__varargs__)
    {
        $macros = $this->macros;
        $context = $this->env->mergeGlobals([
            "collector" => $__collector__,
            "transport" => $__transport__,
            "message" => $__message__,
            "message_is_queued" => $__message_is_queued__,
            "show_transport_name" => $__show_transport_name__,
            "varargs" => $__varargs__,
        ]);

        $blocks = [];

        ob_start();
        try {
            $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
            $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "macro", "render_email_details"));

            $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
            $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "macro", "render_email_details"));

            // line 319
            echo "        ";
            if ((isset($context["show_transport_name"]) || array_key_exists("show_transport_name", $context) ? $context["show_transport_name"] : (function () { throw new RuntimeError('Variable "show_transport_name" does not exist.', 319, $this->source); })())) {
                // line 320
                echo "            <p class=\"mailer-transport-information\">
                <strong>Status:</strong> <span class=\"badge badge-";
                // line 321
                echo (((isset($context["message_is_queued"]) || array_key_exists("message_is_queued", $context) ? $context["message_is_queued"] : (function () { throw new RuntimeError('Variable "message_is_queued" does not exist.', 321, $this->source); })())) ? ("warning") : ("success"));
                echo "\">";
                echo (((isset($context["message_is_queued"]) || array_key_exists("message_is_queued", $context) ? $context["message_is_queued"] : (function () { throw new RuntimeError('Variable "message_is_queued" does not exist.', 321, $this->source); })())) ? ("Queued") : ("Sent"));
                echo "</span>
                &bull;
                <strong>Transport:</strong> <code>";
                // line 323
                echo twig_escape_filter($this->env, (isset($context["transport"]) || array_key_exists("transport", $context) ? $context["transport"] : (function () { throw new RuntimeError('Variable "transport" does not exist.', 323, $this->source); })()), "html", null, true);
                echo "</code>
            </p>
        ";
            }
            // line 326
            echo "
        ";
            // line 327
            if ( !twig_get_attribute($this->env, $this->source, ($context["message"] ?? null), "headers", [], "any", true, true, false, 327)) {
                // line 328
                echo "            ";
                // line 329
                echo "            <a class=\"mailer-message-download-raw\" href=\"data:application/octet-stream;base64,";
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 329, $this->source); })()), "base64Encode", [twig_get_attribute($this->env, $this->source, (isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new RuntimeError('Variable "message" does not exist.', 329, $this->source); })()), "toString", [], "method", false, false, false, 329)], "method", false, false, false, 329), "html", null, true);
                echo "\" download=\"email.eml\">
                ";
                // line 330
                echo twig_source($this->env, "@WebProfiler/Icon/download.svg");
                echo "
                Download as EML file
            </a>

            <pre class=\"prewrap\" style=\"max-height: 600px; margin-left: 5px\">";
                // line 334
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new RuntimeError('Variable "message" does not exist.', 334, $this->source); })()), "toString", [], "method", false, false, false, 334), "html", null, true);
                echo "</pre>
        ";
            } else {
                // line 336
                echo "            <div class=\"sf-tabs\">
                <div class=\"tab\">
                    <h3 class=\"tab-title\">Email contents</h3>
                    <div class=\"tab-content\">
                        <div class=\"card-block\">
                            <p class=\"mailer-message-subject\">
                                ";
                // line 342
                if (twig_get_attribute($this->env, $this->source, ($context["message"] ?? null), "subject", [], "any", true, true, false, 342)) {
                    // line 343
                    echo "                                    ";
                    (((twig_get_attribute($this->env, $this->source, ($context["message"] ?? null), "getSubject", [], "method", true, true, false, 343) &&  !(null === twig_get_attribute($this->env, $this->source, ($context["message"] ?? null), "getSubject", [], "method", false, false, false, 343)))) ? (print (twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, ($context["message"] ?? null), "getSubject", [], "method", false, false, false, 343), "html", null, true))) : (print ("(No subject)")));
                    echo "
                                ";
                } elseif (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source,                 // line 344
(isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new RuntimeError('Variable "message" does not exist.', 344, $this->source); })()), "headers", [], "any", false, false, false, 344), "has", ["subject"], "method", false, false, false, 344)) {
                    // line 345
                    echo "                                    ";
                    echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["message"] ?? null), "headers", [], "any", false, true, false, 345), "get", ["subject"], "method", false, true, false, 345), "bodyAsString", [], "method", true, true, false, 345)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["message"] ?? null), "headers", [], "any", false, true, false, 345), "get", ["subject"], "method", false, true, false, 345), "bodyAsString", [], "method", false, false, false, 345), "(No subject)")) : ("(No subject)")), "html", null, true);
                    echo "
                                ";
                } else {
                    // line 347
                    echo "                                    (No subject)
                                ";
                }
                // line 349
                echo "                            </p>
                            <div class=\"mailer-message-headers\">
                                <p>
                                    <strong>From:</strong>
                                    ";
                // line 353
                if (twig_get_attribute($this->env, $this->source, ($context["message"] ?? null), "from", [], "any", true, true, false, 353)) {
                    // line 354
                    echo "                                        ";
                    echo twig_escape_filter($this->env, _twig_default_filter(twig_join_filter(twig_array_map($this->env, twig_get_attribute($this->env, $this->source, (isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new RuntimeError('Variable "message" does not exist.', 354, $this->source); })()), "getFrom", [], "method", false, false, false, 354), function ($__addr__) use ($context, $macros) { $context["addr"] = $__addr__; return twig_get_attribute($this->env, $this->source, (isset($context["addr"]) || array_key_exists("addr", $context) ? $context["addr"] : (function () { throw new RuntimeError('Variable "addr" does not exist.', 354, $this->source); })()), "toString", [], "method", false, false, false, 354); }), ", "), "(empty)"), "html", null, true);
                    echo "
                                    ";
                } elseif (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source,                 // line 355
(isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new RuntimeError('Variable "message" does not exist.', 355, $this->source); })()), "headers", [], "any", false, false, false, 355), "has", ["from"], "method", false, false, false, 355)) {
                    // line 356
                    echo "                                        ";
                    echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["message"] ?? null), "headers", [], "any", false, true, false, 356), "get", ["from"], "method", false, true, false, 356), "bodyAsString", [], "method", true, true, false, 356)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["message"] ?? null), "headers", [], "any", false, true, false, 356), "get", ["from"], "method", false, true, false, 356), "bodyAsString", [], "method", false, false, false, 356), "(empty)")) : ("(empty)")), "html", null, true);
                    echo "
                                    ";
                } else {
                    // line 358
                    echo "                                        (empty)
                                    ";
                }
                // line 360
                echo "                                </p>
                                <p>
                                    <strong>To:</strong>
                                    ";
                // line 363
                if (twig_get_attribute($this->env, $this->source, ($context["message"] ?? null), "to", [], "any", true, true, false, 363)) {
                    // line 364
                    echo "                                        ";
                    echo twig_escape_filter($this->env, _twig_default_filter(twig_join_filter(twig_array_map($this->env, twig_get_attribute($this->env, $this->source, (isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new RuntimeError('Variable "message" does not exist.', 364, $this->source); })()), "getTo", [], "method", false, false, false, 364), function ($__addr__) use ($context, $macros) { $context["addr"] = $__addr__; return twig_get_attribute($this->env, $this->source, (isset($context["addr"]) || array_key_exists("addr", $context) ? $context["addr"] : (function () { throw new RuntimeError('Variable "addr" does not exist.', 364, $this->source); })()), "toString", [], "method", false, false, false, 364); }), ", "), "(empty)"), "html", null, true);
                    echo "
                                    ";
                } elseif (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source,                 // line 365
(isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new RuntimeError('Variable "message" does not exist.', 365, $this->source); })()), "headers", [], "any", false, false, false, 365), "has", ["to"], "method", false, false, false, 365)) {
                    // line 366
                    echo "                                        ";
                    echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["message"] ?? null), "headers", [], "any", false, true, false, 366), "get", ["to"], "method", false, true, false, 366), "bodyAsString", [], "method", true, true, false, 366)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, ($context["message"] ?? null), "headers", [], "any", false, true, false, 366), "get", ["to"], "method", false, true, false, 366), "bodyAsString", [], "method", false, false, false, 366), "(empty)")) : ("(empty)")), "html", null, true);
                    echo "
                                    ";
                } else {
                    // line 368
                    echo "                                        (empty)
                                    ";
                }
                // line 370
                echo "                                </p>
                                ";
                // line 371
                $context['_parent'] = $context;
                $context['_seq'] = twig_ensure_traversable(twig_array_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new RuntimeError('Variable "message" does not exist.', 371, $this->source); })()), "headers", [], "any", false, false, false, 371), "all", [], "any", false, false, false, 371), function ($__header__) use ($context, $macros) { $context["header"] = $__header__; return !twig_in_filter(twig_lower_filter($this->env, (((twig_get_attribute($this->env, $this->source, $context["header"], "name", [], "any", true, true, false, 371) &&  !(null === twig_get_attribute($this->env, $this->source, $context["header"], "name", [], "any", false, false, false, 371)))) ? (twig_get_attribute($this->env, $this->source, $context["header"], "name", [], "any", false, false, false, 371)) : (""))), ["subject", "from", "to"]); }));
                foreach ($context['_seq'] as $context["_key"] => $context["header"]) {
                    // line 372
                    echo "                                    <p class=\"mailer-message-header-secondary\">";
                    echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["header"], "toString", [], "any", false, false, false, 372), "html", null, true);
                    echo "</p>
                                ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['header'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 374
                echo "                            </div>
                        </div>

                        ";
                // line 377
                if ((twig_get_attribute($this->env, $this->source, ($context["message"] ?? null), "attachments", [], "any", true, true, false, 377) && twig_get_attribute($this->env, $this->source, (isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new RuntimeError('Variable "message" does not exist.', 377, $this->source); })()), "attachments", [], "any", false, false, false, 377))) {
                    // line 378
                    echo "                            <div class=\"card-block\">
                                ";
                    // line 379
                    $context["num_of_attachments"] = twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new RuntimeError('Variable "message" does not exist.', 379, $this->source); })()), "attachments", [], "any", false, false, false, 379));
                    // line 380
                    echo "                                ";
                    $context["total_attachments_size_in_bytes"] = twig_array_reduce($this->env, twig_get_attribute($this->env, $this->source, (isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new RuntimeError('Variable "message" does not exist.', 380, $this->source); })()), "attachments", [], "any", false, false, false, 380), function ($__total_size__, $__attachment__) use ($context, $macros) { $context["total_size"] = $__total_size__; $context["attachment"] = $__attachment__; return ((isset($context["total_size"]) || array_key_exists("total_size", $context) ? $context["total_size"] : (function () { throw new RuntimeError('Variable "total_size" does not exist.', 380, $this->source); })()) + twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["attachment"]) || array_key_exists("attachment", $context) ? $context["attachment"] : (function () { throw new RuntimeError('Variable "attachment" does not exist.', 380, $this->source); })()), "body", [], "any", false, false, false, 380))); }, 0);
                    // line 381
                    echo "                                <p class=\"mailer-message-attachments-title\">
                                    ";
                    // line 382
                    echo twig_source($this->env, "@WebProfiler/Icon/attachment.svg");
                    echo "
                                    Attachments <span>(";
                    // line 383
                    echo twig_escape_filter($this->env, (isset($context["num_of_attachments"]) || array_key_exists("num_of_attachments", $context) ? $context["num_of_attachments"] : (function () { throw new RuntimeError('Variable "num_of_attachments" does not exist.', 383, $this->source); })()), "html", null, true);
                    echo " file";
                    echo ((((isset($context["num_of_attachments"]) || array_key_exists("num_of_attachments", $context) ? $context["num_of_attachments"] : (function () { throw new RuntimeError('Variable "num_of_attachments" does not exist.', 383, $this->source); })()) > 1)) ? ("s") : (""));
                    echo " / ";
                    echo twig_call_macro($macros["_self"], "macro_render_file_size_humanized", [(isset($context["total_attachments_size_in_bytes"]) || array_key_exists("total_attachments_size_in_bytes", $context) ? $context["total_attachments_size_in_bytes"] : (function () { throw new RuntimeError('Variable "total_attachments_size_in_bytes" does not exist.', 383, $this->source); })())], 383, $context, $this->getSourceContext());
                    echo ")</span>
                                </p>

                                <ul class=\"mailer-message-attachments-list\">
                                    ";
                    // line 387
                    $context['_parent'] = $context;
                    $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, (isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new RuntimeError('Variable "message" does not exist.', 387, $this->source); })()), "attachments", [], "any", false, false, false, 387));
                    foreach ($context['_seq'] as $context["_key"] => $context["attachment"]) {
                        // line 388
                        echo "                                        <li>
                                            ";
                        // line 389
                        echo twig_source($this->env, "@WebProfiler/Icon/file.svg");
                        echo "

                                            ";
                        // line 391
                        if (((twig_get_attribute($this->env, $this->source, $context["attachment"], "filename", [], "any", true, true, false, 391)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, $context["attachment"], "filename", [], "any", false, false, false, 391))) : (""))) {
                            // line 392
                            echo "                                                ";
                            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["attachment"], "filename", [], "any", false, false, false, 392), "html", null, true);
                            echo "
                                            ";
                        } else {
                            // line 394
                            echo "                                                <em>(no filename)</em>
                                            ";
                        }
                        // line 396
                        echo "
                                            (";
                        // line 397
                        echo twig_call_macro($macros["_self"], "macro_render_file_size_humanized", [twig_length_filter($this->env, twig_get_attribute($this->env, $this->source, $context["attachment"], "body", [], "any", false, false, false, 397))], 397, $context, $this->getSourceContext());
                        echo ")

                                            <a href=\"data:";
                        // line 399
                        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, $context["attachment"], "contentType", [], "any", true, true, false, 399)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, $context["attachment"], "contentType", [], "any", false, false, false, 399), "application/octet-stream")) : ("application/octet-stream")), "html", null, true);
                        echo ";base64,";
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 399, $this->source); })()), "base64Encode", [twig_get_attribute($this->env, $this->source, $context["attachment"], "body", [], "any", false, false, false, 399)], "method", false, false, false, 399), "html", null, true);
                        echo "\" download=\"";
                        echo twig_escape_filter($this->env, ((twig_get_attribute($this->env, $this->source, $context["attachment"], "filename", [], "any", true, true, false, 399)) ? (_twig_default_filter(twig_get_attribute($this->env, $this->source, $context["attachment"], "filename", [], "any", false, false, false, 399), "attachment")) : ("attachment")), "html", null, true);
                        echo "\">Download</a>
                                        </li>
                                    ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['attachment'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 402
                    echo "                                </ul>
                            </div>
                        ";
                }
                // line 405
                echo "
                        <div class=\"card-block\">
                            <div class=\"sf-tabs sf-tabs-sm\">
                            ";
                // line 408
                if (twig_get_attribute($this->env, $this->source, ($context["message"] ?? null), "htmlBody", [], "any", true, true, false, 408)) {
                    // line 409
                    echo "                                ";
                    $context["textBody"] = twig_get_attribute($this->env, $this->source, (isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new RuntimeError('Variable "message" does not exist.', 409, $this->source); })()), "textBody", [], "any", false, false, false, 409);
                    // line 410
                    echo "                                ";
                    $context["htmlBody"] = twig_get_attribute($this->env, $this->source, (isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new RuntimeError('Variable "message" does not exist.', 410, $this->source); })()), "htmlBody", [], "any", false, false, false, 410);
                    // line 411
                    echo "                                <div class=\"tab ";
                    echo (( !(isset($context["textBody"]) || array_key_exists("textBody", $context) ? $context["textBody"] : (function () { throw new RuntimeError('Variable "textBody" does not exist.', 411, $this->source); })())) ? ("disabled") : (""));
                    echo " ";
                    echo (((isset($context["textBody"]) || array_key_exists("textBody", $context) ? $context["textBody"] : (function () { throw new RuntimeError('Variable "textBody" does not exist.', 411, $this->source); })())) ? ("active") : (""));
                    echo "\">
                                    <h3 class=\"tab-title\">Text content</h3>
                                    <div class=\"tab-content\">
                                        ";
                    // line 414
                    if ((isset($context["textBody"]) || array_key_exists("textBody", $context) ? $context["textBody"] : (function () { throw new RuntimeError('Variable "textBody" does not exist.', 414, $this->source); })())) {
                        // line 415
                        echo "                                            <pre class=\"mailer-email-body prewrap\" style=\"max-height: 600px\">";
                        // line 416
                        if (twig_get_attribute($this->env, $this->source, (isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new RuntimeError('Variable "message" does not exist.', 416, $this->source); })()), "textCharset", [], "method", false, false, false, 416)) {
                            // line 417
                            echo twig_escape_filter($this->env, twig_convert_encoding((isset($context["textBody"]) || array_key_exists("textBody", $context) ? $context["textBody"] : (function () { throw new RuntimeError('Variable "textBody" does not exist.', 417, $this->source); })()), "UTF-8", twig_get_attribute($this->env, $this->source, (isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new RuntimeError('Variable "message" does not exist.', 417, $this->source); })()), "textCharset", [], "method", false, false, false, 417)), "html", null, true);
                        } else {
                            // line 419
                            echo twig_escape_filter($this->env, (isset($context["textBody"]) || array_key_exists("textBody", $context) ? $context["textBody"] : (function () { throw new RuntimeError('Variable "textBody" does not exist.', 419, $this->source); })()), "html", null, true);
                        }
                        // line 421
                        echo "</pre>
                                        ";
                    } else {
                        // line 423
                        echo "                                            <div class=\"mailer-empty-email-body\">
                                                <p>The text body is empty.</p>
                                            </div>
                                        ";
                    }
                    // line 427
                    echo "                                    </div>
                                </div>

                                ";
                    // line 430
                    if ((isset($context["htmlBody"]) || array_key_exists("htmlBody", $context) ? $context["htmlBody"] : (function () { throw new RuntimeError('Variable "htmlBody" does not exist.', 430, $this->source); })())) {
                        // line 431
                        echo "                                    <div class=\"tab\">
                                        <h3 class=\"tab-title\">HTML preview</h3>
                                        <div class=\"tab-content\">
                                            <pre class=\"prewrap\" style=\"max-height: 600px\"><iframe src=\"data:text/html;charset=utf-8;base64,";
                        // line 434
                        echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 434, $this->source); })()), "base64Encode", [(isset($context["htmlBody"]) || array_key_exists("htmlBody", $context) ? $context["htmlBody"] : (function () { throw new RuntimeError('Variable "htmlBody" does not exist.', 434, $this->source); })())], "method", false, false, false, 434), "html", null, true);
                        echo "\" style=\"height: 80vh;width: 100%;\"></iframe>
                                            </pre>
                                        </div>
                                    </div>
                                ";
                    }
                    // line 439
                    echo "
                                <div class=\"tab ";
                    // line 440
                    echo (( !(isset($context["htmlBody"]) || array_key_exists("htmlBody", $context) ? $context["htmlBody"] : (function () { throw new RuntimeError('Variable "htmlBody" does not exist.', 440, $this->source); })())) ? ("disabled") : (""));
                    echo " ";
                    echo ((( !(isset($context["textBody"]) || array_key_exists("textBody", $context) ? $context["textBody"] : (function () { throw new RuntimeError('Variable "textBody" does not exist.', 440, $this->source); })()) && (isset($context["htmlBody"]) || array_key_exists("htmlBody", $context) ? $context["htmlBody"] : (function () { throw new RuntimeError('Variable "htmlBody" does not exist.', 440, $this->source); })()))) ? ("active") : (""));
                    echo "\">
                                    <h3 class=\"tab-title\">HTML content</h3>
                                    <div class=\"tab-content\">
                                        ";
                    // line 443
                    if ((isset($context["htmlBody"]) || array_key_exists("htmlBody", $context) ? $context["htmlBody"] : (function () { throw new RuntimeError('Variable "htmlBody" does not exist.', 443, $this->source); })())) {
                        // line 444
                        echo "                                            <pre class=\"mailer-email-body prewrap\" style=\"max-height: 600px\">";
                        // line 445
                        if (twig_get_attribute($this->env, $this->source, (isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new RuntimeError('Variable "message" does not exist.', 445, $this->source); })()), "htmlCharset", [], "method", false, false, false, 445)) {
                            // line 446
                            echo twig_escape_filter($this->env, twig_convert_encoding((isset($context["htmlBody"]) || array_key_exists("htmlBody", $context) ? $context["htmlBody"] : (function () { throw new RuntimeError('Variable "htmlBody" does not exist.', 446, $this->source); })()), "UTF-8", twig_get_attribute($this->env, $this->source, (isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new RuntimeError('Variable "message" does not exist.', 446, $this->source); })()), "htmlCharset", [], "method", false, false, false, 446)), "html", null, true);
                        } else {
                            // line 448
                            echo twig_escape_filter($this->env, (isset($context["htmlBody"]) || array_key_exists("htmlBody", $context) ? $context["htmlBody"] : (function () { throw new RuntimeError('Variable "htmlBody" does not exist.', 448, $this->source); })()), "html", null, true);
                        }
                        // line 450
                        echo "</pre>
                                        ";
                    } else {
                        // line 452
                        echo "                                            <div class=\"mailer-empty-email-body\">
                                                <p>The HTML body is empty.</p>
                                            </div>
                                        ";
                    }
                    // line 456
                    echo "                                    </div>
                                </div>
                            ";
                } else {
                    // line 459
                    echo "                                ";
                    $context["body"] = ((twig_get_attribute($this->env, $this->source, (isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new RuntimeError('Variable "message" does not exist.', 459, $this->source); })()), "body", [], "any", false, false, false, 459)) ? (twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new RuntimeError('Variable "message" does not exist.', 459, $this->source); })()), "body", [], "any", false, false, false, 459), "toString", [], "method", false, false, false, 459)) : (null));
                    // line 460
                    echo "                                <div class=\"tab ";
                    echo (( !(isset($context["body"]) || array_key_exists("body", $context) ? $context["body"] : (function () { throw new RuntimeError('Variable "body" does not exist.', 460, $this->source); })())) ? ("disabled") : (""));
                    echo " ";
                    echo (((isset($context["body"]) || array_key_exists("body", $context) ? $context["body"] : (function () { throw new RuntimeError('Variable "body" does not exist.', 460, $this->source); })())) ? ("active") : (""));
                    echo "\">
                                    <h3 class=\"tab-title\">Content</h3>
                                    <div class=\"tab-content\">
                                        ";
                    // line 463
                    if ((isset($context["body"]) || array_key_exists("body", $context) ? $context["body"] : (function () { throw new RuntimeError('Variable "body" does not exist.', 463, $this->source); })())) {
                        // line 464
                        echo "                                            <pre class=\"mailer-email-body prewrap\" style=\"max-height: 600px\">";
                        // line 465
                        echo twig_escape_filter($this->env, (isset($context["body"]) || array_key_exists("body", $context) ? $context["body"] : (function () { throw new RuntimeError('Variable "body" does not exist.', 465, $this->source); })()), "html", null, true);
                        echo "
                                            </pre>
                                        ";
                    } else {
                        // line 468
                        echo "                                            <div class=\"mailer-empty-email-body\">
                                                <p>The body is empty.</p>
                                            </div>
                                        ";
                    }
                    // line 472
                    echo "                                    </div>
                                </div>
                            ";
                }
                // line 475
                echo "                            </div>
                        </div>
                    </div>
                </div>

                <div class=\"tab\">
                    <h3 class=\"tab-title\">MIME parts</h3>
                    <div class=\"tab-content\">
                        <pre class=\"prewrap\" style=\"max-height: 600px; margin-left: 5px\">";
                // line 483
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, twig_get_attribute($this->env, $this->source, (isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new RuntimeError('Variable "message" does not exist.', 483, $this->source); })()), "body", [], "method", false, false, false, 483), "asDebugString", [], "method", false, false, false, 483), "html", null, true);
                echo "</pre>
                    </div>
                </div>

                <div class=\"tab\">
                    <h3 class=\"tab-title\">Raw Message</h3>
                    <div class=\"tab-content\">
                        <a class=\"mailer-message-download-raw\" href=\"data:application/octet-stream;base64,";
                // line 490
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["collector"]) || array_key_exists("collector", $context) ? $context["collector"] : (function () { throw new RuntimeError('Variable "collector" does not exist.', 490, $this->source); })()), "base64Encode", [twig_get_attribute($this->env, $this->source, (isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new RuntimeError('Variable "message" does not exist.', 490, $this->source); })()), "toString", [], "method", false, false, false, 490)], "method", false, false, false, 490), "html", null, true);
                echo "\" download=\"email.eml\">
                            ";
                // line 491
                echo twig_source($this->env, "@WebProfiler/Icon/download.svg");
                echo "
                            Download as EML file
                        </a>

                        <pre class=\"prewrap\" style=\"max-height: 600px; margin-left: 5px\">";
                // line 495
                echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, (isset($context["message"]) || array_key_exists("message", $context) ? $context["message"] : (function () { throw new RuntimeError('Variable "message" does not exist.', 495, $this->source); })()), "toString", [], "method", false, false, false, 495), "html", null, true);
                echo "</pre>
                    </div>
                </div>
            </div>
        ";
            }
            // line 500
            echo "    ";
            
            $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

            
            $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);


            return ('' === $tmp = ob_get_contents()) ? '' : new Markup($tmp, $this->env->getCharset());
        } finally {
            ob_end_clean();
        }
    }

    // line 502
    public function macro_render_file_size_humanized($__bytes__ = null, ...$__varargs__)
    {
        $macros = $this->macros;
        $context = $this->env->mergeGlobals([
            "bytes" => $__bytes__,
            "varargs" => $__varargs__,
        ]);

        $blocks = [];

        ob_start();
        try {
            $__internal_5a27a8ba21ca79b61932376b2fa922d2 = $this->extensions["Symfony\\Bundle\\WebProfilerBundle\\Twig\\WebProfilerExtension"];
            $__internal_5a27a8ba21ca79b61932376b2fa922d2->enter($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "macro", "render_file_size_humanized"));

            $__internal_6f47bbe9983af81f1e7450e9a3e3768f = $this->extensions["Symfony\\Bridge\\Twig\\Extension\\ProfilerExtension"];
            $__internal_6f47bbe9983af81f1e7450e9a3e3768f->enter($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof = new \Twig\Profiler\Profile($this->getTemplateName(), "macro", "render_file_size_humanized"));

            // line 503
            if (((isset($context["bytes"]) || array_key_exists("bytes", $context) ? $context["bytes"] : (function () { throw new RuntimeError('Variable "bytes" does not exist.', 503, $this->source); })()) < 1000)) {
                // line 504
                echo twig_escape_filter($this->env, ((isset($context["bytes"]) || array_key_exists("bytes", $context) ? $context["bytes"] : (function () { throw new RuntimeError('Variable "bytes" does not exist.', 504, $this->source); })()) . " bytes"), "html", null, true);
            } elseif ((            // line 505
(isset($context["bytes"]) || array_key_exists("bytes", $context) ? $context["bytes"] : (function () { throw new RuntimeError('Variable "bytes" does not exist.', 505, $this->source); })()) < (1000 ** 2))) {
                // line 506
                echo twig_escape_filter($this->env, (twig_number_format_filter($this->env, ((isset($context["bytes"]) || array_key_exists("bytes", $context) ? $context["bytes"] : (function () { throw new RuntimeError('Variable "bytes" does not exist.', 506, $this->source); })()) / 1000), 2) . " kB"), "html", null, true);
            } else {
                // line 508
                echo twig_escape_filter($this->env, (twig_number_format_filter($this->env, ((isset($context["bytes"]) || array_key_exists("bytes", $context) ? $context["bytes"] : (function () { throw new RuntimeError('Variable "bytes" does not exist.', 508, $this->source); })()) / (1000 ** 2)), 2) . " MB"), "html", null, true);
            }
            
            $__internal_6f47bbe9983af81f1e7450e9a3e3768f->leave($__internal_6f47bbe9983af81f1e7450e9a3e3768f_prof);

            
            $__internal_5a27a8ba21ca79b61932376b2fa922d2->leave($__internal_5a27a8ba21ca79b61932376b2fa922d2_prof);


            return ('' === $tmp = ob_get_contents()) ? '' : new Markup($tmp, $this->env->getCharset());
        } finally {
            ob_end_clean();
        }
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "@WebProfiler/Collector/mailer.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  1168 => 508,  1165 => 506,  1163 => 505,  1161 => 504,  1159 => 503,  1140 => 502,  1125 => 500,  1117 => 495,  1110 => 491,  1106 => 490,  1096 => 483,  1086 => 475,  1081 => 472,  1075 => 468,  1069 => 465,  1067 => 464,  1065 => 463,  1056 => 460,  1053 => 459,  1048 => 456,  1042 => 452,  1038 => 450,  1035 => 448,  1032 => 446,  1030 => 445,  1028 => 444,  1026 => 443,  1018 => 440,  1015 => 439,  1007 => 434,  1002 => 431,  1000 => 430,  995 => 427,  989 => 423,  985 => 421,  982 => 419,  979 => 417,  977 => 416,  975 => 415,  973 => 414,  964 => 411,  961 => 410,  958 => 409,  956 => 408,  951 => 405,  946 => 402,  933 => 399,  928 => 397,  925 => 396,  921 => 394,  915 => 392,  913 => 391,  908 => 389,  905 => 388,  901 => 387,  890 => 383,  886 => 382,  883 => 381,  880 => 380,  878 => 379,  875 => 378,  873 => 377,  868 => 374,  859 => 372,  855 => 371,  852 => 370,  848 => 368,  842 => 366,  840 => 365,  835 => 364,  833 => 363,  828 => 360,  824 => 358,  818 => 356,  816 => 355,  811 => 354,  809 => 353,  803 => 349,  799 => 347,  793 => 345,  791 => 344,  786 => 343,  784 => 342,  776 => 336,  771 => 334,  764 => 330,  759 => 329,  757 => 328,  755 => 327,  752 => 326,  746 => 323,  739 => 321,  736 => 320,  733 => 319,  710 => 318,  694 => 315,  688 => 313,  685 => 312,  682 => 311,  665 => 308,  658 => 307,  641 => 306,  635 => 302,  618 => 299,  615 => 298,  611 => 296,  605 => 294,  603 => 293,  598 => 292,  596 => 291,  592 => 289,  588 => 287,  582 => 285,  580 => 284,  575 => 283,  573 => 282,  568 => 280,  561 => 279,  544 => 278,  531 => 267,  528 => 266,  526 => 265,  523 => 264,  502 => 263,  491 => 501,  488 => 317,  485 => 262,  479 => 260,  476 => 259,  468 => 257,  463 => 256,  458 => 255,  456 => 254,  453 => 253,  444 => 247,  436 => 242,  431 => 239,  425 => 235,  423 => 234,  419 => 232,  416 => 231,  406 => 230,  395 => 227,  389 => 224,  386 => 223,  384 => 222,  378 => 219,  374 => 218,  371 => 217,  368 => 216,  358 => 215,  345 => 211,  342 => 210,  336 => 207,  329 => 203,  325 => 201,  323 => 200,  320 => 199,  315 => 197,  310 => 196,  307 => 195,  305 => 194,  302 => 193,  299 => 192,  289 => 191,  250 => 162,  240 => 161,  73 => 4,  63 => 3,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("{% extends '@WebProfiler/Profiler/layout.html.twig' %}

{% block stylesheets %}
    {{  parent() }}

    <style>
        :root {
            --mailer-email-table-wrapper-background: var(--gray-100);
            --mailer-email-table-active-row-background: #dbeafe;
            --mailer-email-table-active-row-color: var(--color-text);
        }
        .theme-dark {
            --mailer-email-table-wrapper-background: var(--gray-900);
            --mailer-email-table-active-row-background: var(--gray-300);
            --mailer-email-table-active-row-color: var(--gray-800);
        }

        .mailer-email-summary-table-wrapper {
            background: var(--mailer-email-table-wrapper-background);
            border-bottom: 4px double var(--table-border-color);
            border-radius: inherit;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            margin: 0 -9px 10px -9px;
            padding-bottom: 10px;
            transform: translateY(-9px);
            max-height: 265px;
            overflow-y: auto;
        }
        .mailer-email-summary-table,
        .mailer-email-summary-table tr,
        .mailer-email-summary-table td {
            border: 0;
            border-radius: inherit;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
            box-shadow: none;
        }
        .mailer-email-summary-table th {
            color: var(--color-muted);
            font-size: 13px;
            padding: 4px 10px;
        }
        .mailer-email-summary-table tr td,
        .mailer-email-summary-table tr:last-of-type td {
            border: solid var(--table-border-color);
            border-width: 1px 0;
        }
        .mailer-email-summary-table-row {
            margin: 5px 0;
        }
        .mailer-email-summary-table-row:hover {
            cursor: pointer;
        }
        .mailer-email-summary-table-row.active {
            background: var(--mailer-email-table-active-row-background);
            color: var(--mailer-email-table-active-row-color);
        }
        .mailer-email-summary-table-row td {
            font-family: var(--font-family-system);
            font-size: inherit;
        }
        .mailer-email-details {
            display: none;
        }
        .mailer-email-details.active {
            display: block;
        }
        .mailer-transport-information {
            border-bottom: 1px solid var(--form-input-border-color);
            padding-bottom: 5px;
            font-size: var(--font-size-body);
            margin: 5px 0 10px 5px;
        }
        .mailer-transport-information .badge {
            font-size: inherit;
            font-weight: inherit;
        }
        .mailer-message-subject {
            font-size: 21px;
            font-weight: bold;
            margin: 5px;
        }
        .mailer-message-headers {
            margin-bottom: 10px;
        }
        .mailer-message-headers p {
            font-size: var(--font-size-body);
            margin: 2px 5px;
        }
        .mailer-message-header-secondary {
            color: var(--color-muted);
        }
        .mailer-message-attachments-title {
            align-items: center;
            display: flex;
            font-size: var(--font-size-body);
            font-weight: 600;
            margin-bottom: 10px;
        }
        .mailer-message-attachments-title svg {
            color: var(--color-muted);
            margin-right: 5px;
            height: 18px;
            width: 18px;
        }
        .mailer-message-attachments-title span {
            font-weight: normal;
            margin-left: 4px;
        }
        .mailer-message-attachments-list {
            list-style: none;
            margin: 0 0 5px 20px;
            padding: 0;
        }
        .mailer-message-attachments-list li {
            align-items: center;
            display: flex;
        }
        .mailer-message-attachments-list li svg {
            margin-right: 5px;
            height: 18px;
            width: 18px;
        }
        .mailer-message-attachments-list li a {
            margin-left: 5px;
        }
        .mailer-email-body {
            margin: 0;
            padding: 6px 8px;
        }
        .mailer-empty-email-body {
            background-image: url(\"data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' stroke='%23e5e5e5' stroke-width='4' stroke-dasharray='6%2c 14' stroke-dashoffset='0' stroke-linecap='square'/%3e%3c/svg%3e\");
            border-radius: 6px;
            color: var(--color-muted);
            margin: 1em 0 0;
            padding: .5em 1em;
        }
        .theme-dark .mailer-empty-email-body {
            background-image: url(\"data:image/svg+xml,%3csvg width='100%25' height='100%25' xmlns='http://www.w3.org/2000/svg'%3e%3crect width='100%25' height='100%25' fill='none' stroke='%23737373' stroke-width='4' stroke-dasharray='6%2c 14' stroke-dashoffset='0' stroke-linecap='square'/%3e%3c/svg%3e\");
        }
        .mailer-empty-email-body p {
            font-size: var(--font-size-body);
            margin: 0;
            padding: 0.5em 0;
        }

        .mailer-message-download-raw {
            align-items: center;
            display: flex;
            padding: 5px 0 0 5px;
        }
        .mailer-message-download-raw svg {
            height: 18px;
            width: 18px;
            margin-right: 3px;
        }
    </style>
{% endblock %}

{% block javascripts %}
    {{ parent() }}

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            new SymfonyProfilerMailerPanel();
        });

        class SymfonyProfilerMailerPanel {
            constructor() {
                this.#initializeEmailsTable();
            }

            #initializeEmailsTable() {
                const emailRows = document.querySelectorAll('.mailer-email-summary-table-row');

                emailRows.forEach((emailRow) => {
                    emailRow.addEventListener('click', () => {
                        emailRows.forEach((row) => row.classList.remove('active'));
                        emailRow.classList.add('active');

                        document.querySelectorAll('.mailer-email-details').forEach((emailDetails) => emailDetails.style.display = 'none');
                        document.querySelector(emailRow.getAttribute('data-target')).style.display = 'block';
                    });
                });
            }
        }
    </script>
{% endblock %}

{% block toolbar %}
    {% set events = collector.events %}

    {% if events.messages|length %}
        {% set icon %}
            {{ source('@WebProfiler/Icon/mailer.svg') }}
            <span class=\"sf-toolbar-value\">{{ events.messages|length }}</span>
        {% endset %}

        {% set text %}
            <div class=\"sf-toolbar-info-piece\">
                <b>Queued messages</b>
                <span class=\"sf-toolbar-status\">{{ events.events|filter(e => e.isQueued())|length }}</span>
            </div>
            <div class=\"sf-toolbar-info-piece\">
                <b>Sent messages</b>
                <span class=\"sf-toolbar-status\">{{ events.events|filter(e => not e.isQueued())|length }}</span>
            </div>
        {% endset %}

        {{ include('@WebProfiler/Profiler/toolbar_item.html.twig', { 'link': profiler_url }) }}
    {% endif %}
{% endblock %}

{% block menu %}
    {% set events = collector.events %}

    <span class=\"label {{ events.messages is empty ? 'disabled' }}\">
        <span class=\"icon\">{{ source('@WebProfiler/Icon/mailer.svg') }}</span>

        <strong>Emails</strong>
        {% if events.messages|length > 0 %}
            <span class=\"count\">
                <span>{{ events.messages|length }}</span>
            </span>
        {% endif %}
    </span>
{% endblock %}

{% block panel %}
    {% set events = collector.events %}
    <h2>Emails</h2>

    {% if not events.messages|length %}
        <div class=\"empty empty-panel\">
            <p>No emails were sent.</p>
        </div>
    {% else %}
        <div class=\"metrics\">
            <div class=\"metric-group\">
                <div class=\"metric\">
                    <span class=\"value\">{{ events.events|filter(e => e.isQueued())|length }}</span>
                    <span class=\"label\">Queued</span>
                </div>

                <div class=\"metric\">
                    <span class=\"value\">{{ events.events|filter(e => not e.isQueued())|length }}</span>
                    <span class=\"label\">Sent</span>
                </div>
            </div>
        </div>
    {% endif %}

    {% if events.transports|length > 1 %}
        {% for transport in events.transports %}
            <h2><code>{{ transport }}</code> transport</h2>
            {{ _self.render_transport_details(collector, transport) }}
        {% endfor %}
    {% elseif events.transports is not empty %}
        {{ _self.render_transport_details(collector, events.transports|first, true) }}
    {% endif %}

    {% macro render_transport_details(collector, transport, show_transport_name = false) %}
        <div class=\"card\">
            {% set num_emails = collector.events.events(transport)|length %}
            {% if num_emails > 1 %}
                <div class=\"mailer-email-summary-table-wrapper\">
                    <table class=\"mailer-email-summary-table\">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Subject</th>
                                <th>To</th>
                                <th class=\"visually-hidden\">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {% for event in collector.events.events(transport) %}
                                <tr class=\"mailer-email-summary-table-row {{ loop.first ? 'active' }}\" data-target=\"#email-{{ loop.index }}\">
                                    <td>{{ loop.index }}</td>
                                    <td>
                                        {% if event.message.subject is defined %}
                                            {{ event.message.getSubject() ?? '(No subject)' }}
                                        {% elseif event.message.headers.has('subject') %}
                                            {{ event.message.headers.get('subject').bodyAsString()|default('(No subject)') }}
                                        {% else %}
                                            (No subject)
                                        {% endif %}
                                    </td>
                                    <td>
                                        {% if event.message.to is defined %}
                                            {{ event.message.getTo()|map(addr => addr.toString())|join(', ')|default('(empty)') }}
                                        {% elseif event.message.headers.has('to') %}
                                            {{ event.message.headers.get('to').bodyAsString()|default('(empty)') }}
                                        {% else %}
                                            (empty)
                                        {% endif %}
                                    </td>
                                    <td class=\"visually-hidden\"><button class=\"mailer-email-summary-table-row-button\" data-target=\"#email-{{ loop.index }}\">View email details</button></td>
                                </tr>
                            {% endfor %}
                        </tbody>
                    </table>
                </div>

                {% for event in collector.events.events(transport) %}
                    <div class=\"mailer-email-details {{ loop.first ? 'active' }}\" id=\"email-{{ loop.index }}\">
                        {{ _self.render_email_details(collector, transport, event.message, event.isQueued, show_transport_name) }}
                    </div>
                {% endfor %}
            {% else %}
                {% set event = (collector.events.events(transport)|first) %}
                {{ _self.render_email_details(collector, transport, event.message, event.isQueued, show_transport_name) }}
            {% endif %}
        </div>
    {% endmacro %}

    {% macro render_email_details(collector, transport, message, message_is_queued, show_transport_name = false) %}
        {% if show_transport_name %}
            <p class=\"mailer-transport-information\">
                <strong>Status:</strong> <span class=\"badge badge-{{ message_is_queued ? 'warning' : 'success' }}\">{{ message_is_queued ? 'Queued' : 'Sent' }}</span>
                &bull;
                <strong>Transport:</strong> <code>{{ transport }}</code>
            </p>
        {% endif %}

        {% if message.headers is not defined %}
            {# render the raw message contents #}
            <a class=\"mailer-message-download-raw\" href=\"data:application/octet-stream;base64,{{ collector.base64Encode(message.toString()) }}\" download=\"email.eml\">
                {{ source('@WebProfiler/Icon/download.svg') }}
                Download as EML file
            </a>

            <pre class=\"prewrap\" style=\"max-height: 600px; margin-left: 5px\">{{ message.toString() }}</pre>
        {% else %}
            <div class=\"sf-tabs\">
                <div class=\"tab\">
                    <h3 class=\"tab-title\">Email contents</h3>
                    <div class=\"tab-content\">
                        <div class=\"card-block\">
                            <p class=\"mailer-message-subject\">
                                {% if message.subject is defined %}
                                    {{ message.getSubject() ?? '(No subject)' }}
                                {% elseif message.headers.has('subject') %}
                                    {{ message.headers.get('subject').bodyAsString()|default('(No subject)') }}
                                {% else %}
                                    (No subject)
                                {% endif %}
                            </p>
                            <div class=\"mailer-message-headers\">
                                <p>
                                    <strong>From:</strong>
                                    {% if message.from is defined %}
                                        {{ message.getFrom()|map(addr => addr.toString())|join(', ')|default('(empty)') }}
                                    {% elseif message.headers.has('from') %}
                                        {{ message.headers.get('from').bodyAsString()|default('(empty)') }}
                                    {% else %}
                                        (empty)
                                    {% endif %}
                                </p>
                                <p>
                                    <strong>To:</strong>
                                    {% if message.to is defined %}
                                        {{ message.getTo()|map(addr => addr.toString())|join(', ')|default('(empty)') }}
                                    {% elseif message.headers.has('to') %}
                                        {{ message.headers.get('to').bodyAsString()|default('(empty)') }}
                                    {% else %}
                                        (empty)
                                    {% endif %}
                                </p>
                                {% for header in message.headers.all|filter(header => (header.name ?? '')|lower not in ['subject', 'from', 'to']) %}
                                    <p class=\"mailer-message-header-secondary\">{{ header.toString }}</p>
                                {% endfor %}
                            </div>
                        </div>

                        {% if message.attachments is defined and message.attachments %}
                            <div class=\"card-block\">
                                {% set num_of_attachments = message.attachments|length %}
                                {% set total_attachments_size_in_bytes = message.attachments|reduce((total_size, attachment) => total_size + attachment.body|length, 0) %}
                                <p class=\"mailer-message-attachments-title\">
                                    {{ source('@WebProfiler/Icon/attachment.svg') }}
                                    Attachments <span>({{ num_of_attachments }} file{{ num_of_attachments > 1 ? 's' }} / {{ _self.render_file_size_humanized(total_attachments_size_in_bytes) }})</span>
                                </p>

                                <ul class=\"mailer-message-attachments-list\">
                                    {% for attachment in message.attachments %}
                                        <li>
                                            {{ source('@WebProfiler/Icon/file.svg') }}

                                            {% if attachment.filename|default %}
                                                {{ attachment.filename }}
                                            {% else %}
                                                <em>(no filename)</em>
                                            {% endif %}

                                            ({{ _self.render_file_size_humanized(attachment.body|length) }})

                                            <a href=\"data:{{ attachment.contentType|default('application/octet-stream') }};base64,{{ collector.base64Encode(attachment.body) }}\" download=\"{{ attachment.filename|default('attachment') }}\">Download</a>
                                        </li>
                                    {% endfor %}
                                </ul>
                            </div>
                        {% endif %}

                        <div class=\"card-block\">
                            <div class=\"sf-tabs sf-tabs-sm\">
                            {% if message.htmlBody is defined %}
                                {% set textBody = message.textBody %}
                                {% set htmlBody = message.htmlBody %}
                                <div class=\"tab {{ not textBody ? 'disabled' }} {{ textBody ? 'active' }}\">
                                    <h3 class=\"tab-title\">Text content</h3>
                                    <div class=\"tab-content\">
                                        {% if textBody %}
                                            <pre class=\"mailer-email-body prewrap\" style=\"max-height: 600px\">
                                                {%- if message.textCharset() %}
                                                    {{- textBody|convert_encoding('UTF-8', message.textCharset()) }}
                                                {%- else %}
                                                    {{- textBody }}
                                                {%- endif -%}
                                            </pre>
                                        {% else %}
                                            <div class=\"mailer-empty-email-body\">
                                                <p>The text body is empty.</p>
                                            </div>
                                        {% endif %}
                                    </div>
                                </div>

                                {% if htmlBody %}
                                    <div class=\"tab\">
                                        <h3 class=\"tab-title\">HTML preview</h3>
                                        <div class=\"tab-content\">
                                            <pre class=\"prewrap\" style=\"max-height: 600px\"><iframe src=\"data:text/html;charset=utf-8;base64,{{ collector.base64Encode(htmlBody) }}\" style=\"height: 80vh;width: 100%;\"></iframe>
                                            </pre>
                                        </div>
                                    </div>
                                {% endif %}

                                <div class=\"tab {{ not htmlBody ? 'disabled' }} {{ not textBody and htmlBody ? 'active' }}\">
                                    <h3 class=\"tab-title\">HTML content</h3>
                                    <div class=\"tab-content\">
                                        {% if htmlBody %}
                                            <pre class=\"mailer-email-body prewrap\" style=\"max-height: 600px\">
                                                {%- if message.htmlCharset() %}
                                                    {{- htmlBody|convert_encoding('UTF-8', message.htmlCharset()) }}
                                                {%- else %}
                                                    {{- htmlBody }}
                                                {%- endif -%}
                                            </pre>
                                        {% else %}
                                            <div class=\"mailer-empty-email-body\">
                                                <p>The HTML body is empty.</p>
                                            </div>
                                        {% endif %}
                                    </div>
                                </div>
                            {% else %}
                                {% set body = message.body ? message.body.toString() : null %}
                                <div class=\"tab {{ not body ? 'disabled' }} {{ body ? 'active' }}\">
                                    <h3 class=\"tab-title\">Content</h3>
                                    <div class=\"tab-content\">
                                        {% if body %}
                                            <pre class=\"mailer-email-body prewrap\" style=\"max-height: 600px\">
                                                {{- body }}
                                            </pre>
                                        {% else %}
                                            <div class=\"mailer-empty-email-body\">
                                                <p>The body is empty.</p>
                                            </div>
                                        {% endif %}
                                    </div>
                                </div>
                            {% endif %}
                            </div>
                        </div>
                    </div>
                </div>

                <div class=\"tab\">
                    <h3 class=\"tab-title\">MIME parts</h3>
                    <div class=\"tab-content\">
                        <pre class=\"prewrap\" style=\"max-height: 600px; margin-left: 5px\">{{ message.body().asDebugString() }}</pre>
                    </div>
                </div>

                <div class=\"tab\">
                    <h3 class=\"tab-title\">Raw Message</h3>
                    <div class=\"tab-content\">
                        <a class=\"mailer-message-download-raw\" href=\"data:application/octet-stream;base64,{{ collector.base64Encode(message.toString()) }}\" download=\"email.eml\">
                            {{ source('@WebProfiler/Icon/download.svg') }}
                            Download as EML file
                        </a>

                        <pre class=\"prewrap\" style=\"max-height: 600px; margin-left: 5px\">{{ message.toString() }}</pre>
                    </div>
                </div>
            </div>
        {% endif %}
    {% endmacro %}

    {% macro render_file_size_humanized(bytes) %}
        {%- if bytes < 1000 -%}
            {{- bytes ~ ' bytes' -}}
        {%- elseif bytes < 1000 ** 2 -%}
            {{- (bytes / 1000)|number_format(2) ~ ' kB' -}}
        {%- else -%}
            {{- (bytes / 1000 ** 2)|number_format(2) ~ ' MB' -}}
        {%- endif -%}
    {% endmacro %}
{% endblock %}
", "@WebProfiler/Collector/mailer.html.twig", "C:\\xampp\\htdocs\\cours\\filRouge_repo\\cleanthis\\vendor\\symfony\\web-profiler-bundle\\Resources\\views\\Collector\\mailer.html.twig");
    }
}
