<?php
/**
 * Homepage: the full one-page layout.
 */

$contact_email = zenterra_contact_email();

$statuses = array(
	'sent'    => array( ' success', __( "Thanks! Your request is on its way. We'll reply within 24–48 hours.", 'zenterra' ) ),
	'invalid' => array( ' error', __( 'Please fill in your name, a valid email and your goal.', 'zenterra' ) ),
	'limit'   => array( ' error', __( 'Too many requests from your network. Please email us directly.', 'zenterra' ) ),
	'error'   => array( ' error', __( "Sorry, the message couldn't be sent. Please email us directly.", 'zenterra' ) ),
);
$status = isset( $_GET['contact'] ) ? sanitize_key( wp_unslash( $_GET['contact'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
list( $status_class, $status_text ) = isset( $statuses[ $status ] )
	? $statuses[ $status ]
	: array( '', '' );

get_header();
?>

<main id="main">
<!-- Hero -->
<section class="hero" id="top">
  <div class="container hero-inner">
    <p class="eyebrow"><?php esc_html_e( 'AI-powered development studio', 'zenterra' ); ?></p>
    <h1><?php zenterra_hero_title(); ?></h1>
    <p class="lead"><?php esc_html_e( 'We\'re professional developers with many years of experience behind us. AI makes us faster, but it\'s experience that solves your business problem. Fixed price, honest estimates, and every change reviewed by an experienced developer before it reaches you.', 'zenterra' ); ?></p>
    <div class="hero-cta">
      <a href="#contact" class="btn btn-primary"><?php esc_html_e( 'Get a proposal in 48 hours', 'zenterra' ); ?></a>
      <a href="<?php echo esc_url( ZENTERRA_CALENDLY ); ?>" class="btn btn-ghost" target="_blank" rel="noopener"><svg class="btn-icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="3.5" y="5" width="17" height="15" rx="2.5"/><path d="M3.5 10h17M8 3v4M16 3v4"/></svg><?php esc_html_e( 'Book a free 30-min call', 'zenterra' ); ?></a>
    </div>
    <dl class="stats">
      <div><dt><?php esc_html_e( '1–2 weeks', 'zenterra' ); ?></dt><dd><?php esc_html_e( 'for a typical company website', 'zenterra' ); ?></dd></div>
      <div><dt><?php esc_html_e( 'Fixed price', 'zenterra' ); ?></dt><dd><?php esc_html_e( 'agreed before work starts', 'zenterra' ); ?></dd></div>
      <div><dt><?php esc_html_e( 'Real experience', 'zenterra' ); ?></dt><dd><?php esc_html_e( 'professional developers, not prompt operators', 'zenterra' ); ?></dd></div>
      <div><dt><?php esc_html_e( '100% reviewed', 'zenterra' ); ?></dt><dd><?php esc_html_e( 'every pull request, by a human', 'zenterra' ); ?></dd></div>
    </dl>
  </div>

  <div class="marquee" aria-hidden="true">
    <div class="marquee-track">
      <span>React</span><span>Next.js</span><span>Node.js</span><span>NestJS</span><span>Astro</span><span>PHP</span><span>TypeScript</span><span>JavaScript</span><span>WordPress</span><span>WooCommerce</span><span>React Native</span><span>Claude</span><span>ChatGPT</span><span>Gemini</span><span>Cursor</span><span>React</span><span>Next.js</span><span>Node.js</span><span>NestJS</span><span>Astro</span><span>PHP</span><span>TypeScript</span><span>JavaScript</span><span>WordPress</span><span>WooCommerce</span><span>React Native</span><span>Claude</span><span>ChatGPT</span><span>Gemini</span><span>Cursor</span>
    </div>
    <div class="marquee-track reverse">
      <span><?php esc_html_e( 'Landing pages', 'zenterra' ); ?></span><span><?php esc_html_e( 'Company websites', 'zenterra' ); ?></span><span><?php esc_html_e( 'Online stores', 'zenterra' ); ?></span><span><?php esc_html_e( 'Redesigns', 'zenterra' ); ?></span><span><?php esc_html_e( 'AI chatbots', 'zenterra' ); ?></span><span><?php esc_html_e( 'Automation', 'zenterra' ); ?></span><span><?php esc_html_e( 'Web apps', 'zenterra' ); ?></span><span><?php esc_html_e( 'Mobile apps', 'zenterra' ); ?></span><span><?php esc_html_e( 'MVPs', 'zenterra' ); ?></span><span><?php esc_html_e( 'Website support', 'zenterra' ); ?></span><span><?php esc_html_e( 'Landing pages', 'zenterra' ); ?></span><span><?php esc_html_e( 'Company websites', 'zenterra' ); ?></span><span><?php esc_html_e( 'Online stores', 'zenterra' ); ?></span><span><?php esc_html_e( 'Redesigns', 'zenterra' ); ?></span><span><?php esc_html_e( 'AI chatbots', 'zenterra' ); ?></span><span><?php esc_html_e( 'Automation', 'zenterra' ); ?></span><span><?php esc_html_e( 'Web apps', 'zenterra' ); ?></span><span><?php esc_html_e( 'Mobile apps', 'zenterra' ); ?></span><span><?php esc_html_e( 'MVPs', 'zenterra' ); ?></span><span><?php esc_html_e( 'Website support', 'zenterra' ); ?></span>
    </div>
  </div>
</section>

<!-- Why -->
<section class="section" id="why">
  <div class="container">
    <div class="section-head">
      <p class="eyebrow"><?php esc_html_e( 'Why Zenterra', 'zenterra' ); ?></p>
      <h2><?php esc_html_e( 'Agency-grade quality at a freelancer\'s pace', 'zenterra' ); ?></h2>
      <p class="section-lead"><?php esc_html_e( 'Big agencies are reliable but slow and expensive. Solo freelancers are cheaper but unpredictable. We sit in between: a small team of experienced developers who use AI for speed, with a team lead who answers for quality.', 'zenterra' ); ?></p>
    </div>
    <div class="table-wrap">
      <table class="compare">
        <thead>
          <tr><th scope="col"></th><th scope="col"><?php esc_html_e( 'Typical agency', 'zenterra' ); ?></th><th scope="col"><?php esc_html_e( 'Freelancer', 'zenterra' ); ?></th><th scope="col" class="hl">Zenterra</th></tr>
        </thead>
        <tbody>
          <tr><th scope="row"><?php esc_html_e( 'Website price', 'zenterra' ); ?></th><td data-label="<?php esc_attr_e( 'Typical agency', 'zenterra' ); ?>"><?php esc_html_e( 'from $1,500–3,500', 'zenterra' ); ?></td><td data-label="<?php esc_attr_e( 'Freelancer', 'zenterra' ); ?>"><?php esc_html_e( 'cheaper', 'zenterra' ); ?></td><td class="hl" data-label="Zenterra"><?php esc_html_e( '$1,300–3,500, fixed', 'zenterra' ); ?></td></tr>
          <tr><th scope="row"><?php esc_html_e( 'Timeline', 'zenterra' ); ?></th><td data-label="<?php esc_attr_e( 'Typical agency', 'zenterra' ); ?>"><?php esc_html_e( 'weeks', 'zenterra' ); ?></td><td data-label="<?php esc_attr_e( 'Freelancer', 'zenterra' ); ?>"><?php esc_html_e( 'unpredictable', 'zenterra' ); ?></td><td class="hl" data-label="Zenterra"><?php esc_html_e( '1–2 weeks for a typical site', 'zenterra' ); ?></td></tr>
          <tr><th scope="row"><?php esc_html_e( 'Team', 'zenterra' ); ?></th><td data-label="<?php esc_attr_e( 'Typical agency', 'zenterra' ); ?>"><?php esc_html_e( 'seniors + account manager', 'zenterra' ); ?></td><td data-label="<?php esc_attr_e( 'Freelancer', 'zenterra' ); ?>"><?php esc_html_e( 'one person', 'zenterra' ); ?></td><td class="hl" data-label="Zenterra"><?php esc_html_e( 'experienced developers, accelerated by AI', 'zenterra' ); ?></td></tr>
          <tr><th scope="row"><?php esc_html_e( 'Quality control', 'zenterra' ); ?></th><td data-label="<?php esc_attr_e( 'Typical agency', 'zenterra' ); ?>"><?php esc_html_e( 'senior review', 'zenterra' ); ?></td><td data-label="<?php esc_attr_e( 'Freelancer', 'zenterra' ); ?>"><?php esc_html_e( 'none', 'zenterra' ); ?></td><td class="hl" data-label="Zenterra"><?php esc_html_e( 'every PR reviewed + launch checklist', 'zenterra' ); ?></td></tr>
        </tbody>
      </table>
    </div>
    <div class="callout">
      <strong><?php esc_html_e( 'You don\'t buy prompts.', 'zenterra' ); ?></strong> <?php esc_html_e( 'You buy a finished website or solution, a deadline and a quality guarantee. Our prompts, templates and checklists are internal tools that make the team fast and consistent.', 'zenterra' ); ?>
    </div>

    <div class="principles">
      <h3 class="h-small"><?php esc_html_e( 'What we stand for', 'zenterra' ); ?></h3>
      <div class="principles-grid snap-row">
        <div class="card principle">
          <span class="principle-n">01</span>
          <h4><?php esc_html_e( 'Experience first, AI second', 'zenterra' ); ?></h4>
          <p><?php esc_html_e( 'AI is a tool in experienced hands. We were building and shipping software long before AI coding assistants existed, and we know where they help and where they fail.', 'zenterra' ); ?></p>
        </div>
        <div class="card principle">
          <span class="principle-n">02</span>
          <h4><?php esc_html_e( 'Real business problems', 'zenterra' ); ?></h4>
          <p><?php esc_html_e( 'We start from what you need to change, whether that\'s more leads, less manual work or a faster site, not from the technology we\'d like to sell.', 'zenterra' ); ?></p>
        </div>
        <div class="card principle">
          <span class="principle-n">03</span>
          <h4><?php esc_html_e( 'Honest estimates', 'zenterra' ); ?></h4>
          <p><?php esc_html_e( 'If a project needs more time or budget, we tell you before you sign, not halfway through. The price we quote is the price you pay.', 'zenterra' ); ?></p>
        </div>
        <div class="card principle">
          <span class="principle-n">04</span>
          <h4><?php esc_html_e( 'No hype, no lies', 'zenterra' ); ?></h4>
          <p><?php esc_html_e( 'We tell you what AI can and can\'t do for you. If a ready-made tool solves your problem for less, we\'ll say so.', 'zenterra' ); ?></p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Services -->
<section class="section section-alt" id="services">
  <div class="container">
    <div class="section-head">
      <p class="eyebrow"><?php esc_html_e( 'Services', 'zenterra' ); ?></p>
      <h2><?php esc_html_e( 'What we build', 'zenterra' ); ?></h2>
    </div>
    <div class="grid-3 snap-row">
      <article class="card service">
        <div class="service-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M7 6.5h.01M10 6.5h.01"/></svg>
        </div>
        <h3><?php esc_html_e( 'Websites', 'zenterra' ); ?></h3>
        <p class="muted"><?php esc_html_e( 'On WordPress, Next.js, Astro or Webflow.', 'zenterra' ); ?></p>
        <ul class="checks">
          <li><?php esc_html_e( 'Landing pages and company websites', 'zenterra' ); ?></li>
          <li><?php esc_html_e( 'Custom WordPress themes and plugins', 'zenterra' ); ?></li>
          <li><?php esc_html_e( 'Redesigns and migrations from Squarespace, older WordPress sites and more', 'zenterra' ); ?></li>
          <li><?php esc_html_e( 'Online stores on WooCommerce', 'zenterra' ); ?></li>
          <li><?php esc_html_e( 'Multilingual sites, animations and integrations', 'zenterra' ); ?></li>
          <li><?php esc_html_e( 'Monthly support and updates', 'zenterra' ); ?></li>
        </ul>
      </article>
      <article class="card service">
        <div class="service-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24"><path d="M12 3l1.8 4.6L18.5 9l-4.7 1.4L12 15l-1.8-4.6L5.5 9l4.7-1.4z"/><path d="M18 15l.9 2.1L21 18l-2.1.9L18 21l-.9-2.1L15 18l2.1-.9z"/></svg>
        </div>
        <h3><?php esc_html_e( 'AI solutions', 'zenterra' ); ?></h3>
        <p class="muted"><?php esc_html_e( 'Built with leading AI models, designed and reviewed in-house.', 'zenterra' ); ?></p>
        <ul class="checks">
          <li><?php esc_html_e( 'Chatbots and assistants trained on your own knowledge base (RAG)', 'zenterra' ); ?></li>
          <li><?php esc_html_e( 'Automated handling of leads, requests and documents', 'zenterra' ); ?></li>
          <li><?php esc_html_e( 'Integrations with your CRM and leading AI model APIs', 'zenterra' ); ?></li>
          <li><?php esc_html_e( 'AI audit: where AI will pay off in your business, with a prototype', 'zenterra' ); ?></li>
        </ul>
      </article>
      <article class="card service">
        <div class="service-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24"><rect x="7" y="2.5" width="10" height="19" rx="2.5"/><path d="M11 18.5h2"/></svg>
        </div>
        <h3><?php esc_html_e( 'Apps & MVPs', 'zenterra' ); ?></h3>
        <p class="muted"><?php esc_html_e( 'For startups that need a first version fast.', 'zenterra' ); ?></p>
        <ul class="checks">
          <li><?php esc_html_e( 'Web apps in React and Next.js', 'zenterra' ); ?></li>
          <li><?php esc_html_e( 'Mobile apps for iOS and Android with React Native', 'zenterra' ); ?></li>
          <li><?php esc_html_e( 'Backends and APIs in Node.js and NestJS', 'zenterra' ); ?></li>
          <li><?php esc_html_e( 'MVPs with AI features built in', 'zenterra' ); ?></li>
          <li><?php esc_html_e( 'Projects typically from $2,500, quoted after a short scoping call', 'zenterra' ); ?></li>
        </ul>
      </article>
    </div>

    <div class="stack">
      <h3 class="h-small"><?php esc_html_e( 'Our stack', 'zenterra' ); ?></h3>
      <dl class="stack-grid snap-row">
        <div><dt><?php esc_html_e( 'Frontend', 'zenterra' ); ?></dt><dd>React</dd><dd>Next.js</dd><dd>Astro</dd><dd>TypeScript</dd><dd>JavaScript</dd><dd>HTML</dd><dd>CSS</dd></div>
        <div><dt><?php esc_html_e( 'Backend', 'zenterra' ); ?></dt><dd>Node.js</dd><dd>NestJS</dd><dd>PHP</dd><dd><?php esc_html_e( 'REST APIs', 'zenterra' ); ?></dd></div>
        <div><dt><?php esc_html_e( 'CMS & e‑commerce', 'zenterra' ); ?></dt><dd>WordPress</dd><dd>WooCommerce</dd><dd><?php esc_html_e( 'Custom WordPress plugins', 'zenterra' ); ?></dd><dd>Webflow</dd></div>
        <div><dt><?php esc_html_e( 'Mobile', 'zenterra' ); ?></dt><dd>React Native</dd><dd>iOS</dd><dd>Android</dd></div>
        <div><dt><?php esc_html_e( 'AI tools', 'zenterra' ); ?></dt><dd>Claude</dd><dd>ChatGPT</dd><dd>Gemini</dd><dd>Cursor</dd><dd>RAG</dd></div>
      </dl>
    </div>
    <div class="audiences">
      <h3 class="h-small"><?php esc_html_e( 'Who we work with', 'zenterra' ); ?></h3>
      <ul class="chips">
        <li><?php esc_html_e( 'Small businesses in Europe and internationally', 'zenterra' ); ?></li>
        <li><?php esc_html_e( 'Startups that need an MVP or AI features', 'zenterra' ); ?></li>
        <li><?php esc_html_e( 'Agencies that need extra hands', 'zenterra' ); ?></li>
        <li><?php esc_html_e( 'Businesses in Ukraine and Poland', 'zenterra' ); ?></li>
      </ul>
    </div>
  </div>
</section>

<!-- Pricing -->
<section class="section" id="pricing">
  <div class="container">
    <div class="section-head">
      <p class="eyebrow"><?php esc_html_e( 'Pricing', 'zenterra' ); ?></p>
      <h2><?php esc_html_e( 'Clear scope. Fixed price.', 'zenterra' ); ?></h2>
      <p class="section-lead"><?php esc_html_e( 'Every project gets a written scope, a timeline and one price. No hourly surprises.', 'zenterra' ); ?></p>
    </div>

    <div class="tabs" role="tablist" aria-label="<?php esc_attr_e( 'Pricing category', 'zenterra' ); ?>">
      <button role="tab" id="tab-web" aria-selected="true" aria-controls="panel-web" type="button"><?php esc_html_e( 'Websites', 'zenterra' ); ?></button>
      <button role="tab" id="tab-ai" aria-selected="false" aria-controls="panel-ai" type="button" tabindex="-1"><?php esc_html_e( 'AI solutions', 'zenterra' ); ?></button>
    </div>

    <div class="price-grid snap-row" id="panel-web" role="tabpanel" aria-labelledby="tab-web">
      <article class="card price">
        <h3><?php esc_html_e( 'Landing page', 'zenterra' ); ?></h3>
        <p class="price-tag"><?php echo esc_html( zenterra_price( 'landing' ) ); ?></p>
        <p class="price-time"><?php esc_html_e( '3–5 days', 'zenterra' ); ?></p>
        <p class="muted"><?php esc_html_e( 'One page, responsive, forms and basic SEO.', 'zenterra' ); ?></p>
      </article>
      <article class="card price featured">
        <span class="badge"><?php esc_html_e( 'Most popular', 'zenterra' ); ?></span>
        <h3><?php esc_html_e( 'Company website', 'zenterra' ); ?></h3>
        <p class="price-tag"><?php echo esc_html( zenterra_price( 'company' ) ); ?></p>
        <p class="price-time"><?php esc_html_e( '1–2 weeks', 'zenterra' ); ?></p>
        <p class="muted"><?php esc_html_e( '5–8 pages, CMS or blog, forms and basic SEO.', 'zenterra' ); ?></p>
      </article>
      <article class="card price">
        <h3><?php esc_html_e( 'Advanced website', 'zenterra' ); ?></h3>
        <p class="price-tag"><?php echo esc_html( zenterra_price( 'advanced' ) ); ?></p>
        <p class="price-time"><?php esc_html_e( '2–4 weeks', 'zenterra' ); ?></p>
        <p class="muted"><?php esc_html_e( 'Animations, integrations, multiple languages, online store.', 'zenterra' ); ?></p>
      </article>
      <article class="card price">
        <h3><?php esc_html_e( 'Redesign / migration', 'zenterra' ); ?></h3>
        <p class="price-tag"><?php echo esc_html( zenterra_price( 'redesign' ) ); ?></p>
        <p class="price-time"><?php esc_html_e( '1–2 weeks', 'zenterra' ); ?></p>
        <p class="muted"><?php esc_html_e( 'Move from WordPress, Squarespace and others, with a fresh design.', 'zenterra' ); ?></p>
      </article>
      <article class="card price">
        <h3><?php esc_html_e( 'Website support', 'zenterra' ); ?></h3>
        <p class="price-tag"><?php echo esc_html( zenterra_price( 'support' ) ); ?><small><?php esc_html_e( '/mo', 'zenterra' ); ?></small></p>
        <p class="price-time"><?php esc_html_e( 'Monthly', 'zenterra' ); ?></p>
        <p class="muted"><?php esc_html_e( 'Edits, updates and uptime checks.', 'zenterra' ); ?></p>
      </article>
    </div>

    <div class="price-grid snap-row" id="panel-ai" role="tabpanel" aria-labelledby="tab-ai" hidden>
      <article class="card price featured">
        <span class="badge"><?php esc_html_e( 'Start here', 'zenterra' ); ?></span>
        <h3><?php esc_html_e( 'AI audit', 'zenterra' ); ?></h3>
        <p class="price-tag"><?php echo esc_html( zenterra_price( 'audit' ) ); ?></p>
        <p class="price-time"><?php esc_html_e( '1 week', 'zenterra' ); ?></p>
        <p class="muted"><?php esc_html_e( 'Where AI will make a difference in your business, plus a working prototype.', 'zenterra' ); ?></p>
      </article>
      <article class="card price">
        <h3><?php esc_html_e( 'AI chatbot / assistant', 'zenterra' ); ?></h3>
        <p class="price-tag"><?php echo esc_html( zenterra_price( 'chatbot' ) ); ?></p>
        <p class="price-time"><?php esc_html_e( '1–3 weeks', 'zenterra' ); ?></p>
        <p class="muted"><?php esc_html_e( 'A bot that answers from your own knowledge base, embedded in your site.', 'zenterra' ); ?></p>
      </article>
      <article class="card price">
        <h3><?php esc_html_e( 'AI automation', 'zenterra' ); ?></h3>
        <p class="price-tag"><?php echo esc_html( zenterra_price( 'automation' ) ); ?></p>
        <p class="price-time"><?php esc_html_e( '2–4 weeks', 'zenterra' ); ?></p>
        <p class="muted"><?php esc_html_e( 'Processing leads and documents, CRM integrations, built on leading AI models.', 'zenterra' ); ?></p>
      </article>
    </div>

    <div class="terms">
      <h3 class="h-small"><?php esc_html_e( 'How payment works', 'zenterra' ); ?></h3>
      <ul class="terms-list">
        <li><strong><?php esc_html_e( '50% upfront', 'zenterra' ); ?></strong> <?php esc_html_e( 'for websites; larger projects are paid 30–50% upfront, then by milestone.', 'zenterra' ); ?></li>
        <li><strong><?php esc_html_e( '2 revision rounds', 'zenterra' ); ?></strong> <?php esc_html_e( 'are included. Anything outside scope becomes a separate, priced change request.', 'zenterra' ); ?></li>
        <li><strong><?php esc_html_e( 'Your accounts, your assets.', 'zenterra' ); ?></strong> <?php esc_html_e( 'Your hosting, domain and AI API usage run on your own accounts.', 'zenterra' ); ?></li>
        <li><strong><?php esc_html_e( 'You own the result.', 'zenterra' ); ?></strong> <?php esc_html_e( 'All rights to the work transfer to you once it\'s paid for.', 'zenterra' ); ?></li>
      </ul>
    </div>
  </div>
</section>

<!-- Process -->
<section class="section section-alt" id="process">
  <div class="container">
    <div class="section-head">
      <p class="eyebrow"><?php esc_html_e( 'Process', 'zenterra' ); ?></p>
      <h2><?php esc_html_e( 'From first message to launch', 'zenterra' ); ?></h2>
    </div>
    <ol class="steps snap-row">
      <li><span class="step-n">1</span><div><h3><?php esc_html_e( 'Request', 'zenterra' ); ?></h3><p><?php esc_html_e( 'Reach out through the form, Upwork or LinkedIn.', 'zenterra' ); ?></p></div></li>
      <li><span class="step-n">2</span><div><h3><?php esc_html_e( 'Brief', 'zenterra' ); ?></h3><p><?php esc_html_e( 'One call or a short form: goals, pages, examples you like, content and access.', 'zenterra' ); ?></p></div></li>
      <li><span class="step-n">3</span><div><h3><?php esc_html_e( 'Proposal', 'zenterra' ); ?></h3><p><?php esc_html_e( 'Scope, timeline and fixed price within 24–48 hours.', 'zenterra' ); ?></p></div></li>
      <li><span class="step-n">4</span><div><h3><?php esc_html_e( '50% deposit', 'zenterra' ); ?></h3><p><?php esc_html_e( 'We lock in the schedule and start work.', 'zenterra' ); ?></p></div></li>
      <li><span class="step-n">5</span><div><h3><?php esc_html_e( 'Structure', 'zenterra' ); ?></h3><p><?php esc_html_e( 'Sitemap, sections and design direction in 1–2 days.', 'zenterra' ); ?></p></div></li>
      <li><span class="step-n">6</span><div><h3><?php esc_html_e( 'Build', 'zenterra' ); ?></h3><p><?php esc_html_e( 'Built by experienced developers with AI assistance, from tested templates, on a staging site, in 3–10 days.', 'zenterra' ); ?></p></div></li>
      <li><span class="step-n">7</span><div><h3><?php esc_html_e( 'Team lead review', 'zenterra' ); ?></h3><p><?php esc_html_e( 'Every change is checked against our launch checklist.', 'zenterra' ); ?></p></div></li>
      <li><span class="step-n">8</span><div><h3><?php esc_html_e( 'Demo & revisions', 'zenterra' ); ?></h3><p><?php esc_html_e( 'You see the result and we do two rounds of revisions.', 'zenterra' ); ?></p></div></li>
      <li><span class="step-n">9</span><div><h3><?php esc_html_e( 'Launch', 'zenterra' ); ?></h3><p><?php esc_html_e( 'Live on your domain with analytics connected. The remaining 50% is due.', 'zenterra' ); ?></p></div></li>
      <li><span class="step-n">10</span><div><h3><?php esc_html_e( 'Support', 'zenterra' ); ?></h3><p><?php esc_html_e( 'Optional monthly care from $90/month.', 'zenterra' ); ?></p></div></li>
    </ol>
  </div>
</section>

<!-- AI-first cycle + DoD -->
<section class="section" id="quality">
  <div class="container">
    <div class="section-head">
      <p class="eyebrow"><?php esc_html_e( 'How we build', 'zenterra' ); ?></p>
      <h2><?php esc_html_e( 'AI does the work. People are accountable for it.', 'zenterra' ); ?></h2>
      <p class="section-lead"><?php esc_html_e( 'AI makes experienced developers faster. Our process makes that speed safe to rely on.', 'zenterra' ); ?></p>
    </div>
    <ol class="cycle snap-row">
      <li><span class="who who-human"><?php esc_html_e( 'Human', 'zenterra' ); ?></span><h3><?php esc_html_e( 'Specification', 'zenterra' ); ?></h3><p><?php esc_html_e( 'Goal, acceptance criteria and what not to do. No spec, no code.', 'zenterra' ); ?></p></li>
      <li><span class="who who-human"><?php esc_html_e( 'Human', 'zenterra' ); ?></span><h3><?php esc_html_e( 'Context', 'zenterra' ); ?></h3><p><?php esc_html_e( 'Every repository has project conventions, commands and section templates.', 'zenterra' ); ?></p></li>
      <li><span class="who who-ai"><?php esc_html_e( 'AI', 'zenterra' ); ?></span><h3><?php esc_html_e( 'Implementation', 'zenterra' ); ?></h3><p><?php esc_html_e( 'Plan first, approved by the lead, then small changes.', 'zenterra' ); ?></p></li>
      <li><span class="who who-ai"><?php esc_html_e( 'Automated', 'zenterra' ); ?></span><h3><?php esc_html_e( 'Checks', 'zenterra' ); ?></h3><p><?php esc_html_e( 'Linters, build, tests, page speed and accessibility checks.', 'zenterra' ); ?></p></li>
      <li><span class="who who-human"><?php esc_html_e( 'Human', 'zenterra' ); ?></span><h3><?php esc_html_e( 'Review', 'zenterra' ); ?></h3><p><?php esc_html_e( 'Every PR: logic, security, responsiveness and matching the spec.', 'zenterra' ); ?></p></li>
      <li><span class="who who-human"><?php esc_html_e( 'Human', 'zenterra' ); ?></span><h3><?php esc_html_e( 'Demo', 'zenterra' ); ?></h3><p><?php esc_html_e( 'You see the result; lessons learned feed back into our playbook.', 'zenterra' ); ?></p></li>
    </ol>

    <div class="grid-2 quality-grid snap-row">
      <div class="card">
        <h3><?php esc_html_e( 'Launch checklist', 'zenterra' ); ?></h3>
        <p class="muted"><?php esc_html_e( 'A site isn\'t done until every box is ticked.', 'zenterra' ); ?></p>
        <ul class="checks">
          <li><?php esc_html_e( 'Spec delivered, both revision rounds closed', 'zenterra' ); ?></li>
          <li><?php esc_html_e( 'Responsive on phone, tablet and desktop', 'zenterra' ); ?></li>
          <li><?php esc_html_e( 'Forms work and submissions arrive', 'zenterra' ); ?></li>
          <li><?php esc_html_e( 'Page speed and basic SEO: headings, meta tags, sitemap', 'zenterra' ); ?></li>
          <li><?php esc_html_e( 'No keys or secrets in the code', 'zenterra' ); ?></li>
          <li><?php esc_html_e( 'Analytics and domain connected', 'zenterra' ); ?></li>
          <li><?php esc_html_e( 'Team lead review passed', 'zenterra' ); ?></li>
          <li><?php esc_html_e( 'You receive all access and a short how-to guide', 'zenterra' ); ?></li>
        </ul>
      </div>
      <div class="card">
        <h3><?php esc_html_e( 'Security & your data', 'zenterra' ); ?></h3>
        <p class="muted"><?php esc_html_e( 'We treat your code and data carefully.', 'zenterra' ); ?></p>
        <ul class="checks">
          <li><?php esc_html_e( 'Client code is handled only in business-grade AI workspaces, where model training on your data is switched off.', 'zenterra' ); ?></li>
          <li><?php esc_html_e( 'Under our AI providers\' commercial terms, you own everything we produce for you.', 'zenterra' ); ?></li>
          <li><?php esc_html_e( 'Separate access for every project, kept in a password manager and revoked when the project ends.', 'zenterra' ); ?></li>
          <li><?php esc_html_e( 'NDA available on request, and a DPA for EU personal data.', 'zenterra' ); ?></li>
          <li><?php esc_html_e( 'Backup power and internet for everyone on the team, so work continues during outages.', 'zenterra' ); ?></li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Agencies -->
<section class="section section-dark" id="agencies">
  <div class="container">
   <div class="agencies-panel">
    <div class="agencies-copy">
      <p class="eyebrow"><?php esc_html_e( 'For agencies', 'zenterra' ); ?></p>
      <h2><?php esc_html_e( 'Your brand. Our team. Fixed price.', 'zenterra' ); ?></h2>
      <p class="section-lead"><?php esc_html_e( 'Too many orders and not enough people? You handle sales and the client relationship. We build websites on WordPress, Next.js or Webflow, plus apps and AI integrations, under your brand.', 'zenterra' ); ?></p>
      <ul class="checks">
        <li><?php esc_html_e( 'White-label delivery, with no contact with your clients unless you want it', 'zenterra' ); ?></li>
        <li><?php esc_html_e( 'Fixed price per project, so your margin is predictable', 'zenterra' ); ?></li>
        <li><?php esc_html_e( 'The same review process and launch checklist on every site', 'zenterra' ); ?></li>
        <li><?php esc_html_e( 'Your first task comes at a discount', 'zenterra' ); ?></li>
      </ul>
      <a href="#contact" class="btn btn-primary" data-topic="White-label partnership"><?php esc_html_e( 'Talk about a partnership', 'zenterra' ); ?></a>
    </div>

    <div class="wl-visual" aria-hidden="true">
      <div class="wl-card wl-back">
        <span class="wl-tag">Zenterra</span>
        <i></i><i></i><i class="short"></i><i></i>
      </div>
      <div class="wl-card wl-front">
        <span class="wl-logo"><?php esc_html_e( 'Your brand', 'zenterra' ); ?></span>
        <i class="wl-hero"></i>
        <i></i><i class="short"></i><i></i>
        <span class="wl-check"><svg viewBox="0 0 24 24"><path d="M6 12.5l4 4 8-9"/></svg><?php esc_html_e( 'Reviewed', 'zenterra' ); ?></span>
      </div>
    </div>
   </div>
  </div>
</section>

<!-- Team -->
<section class="section" id="team">
  <div class="container team-inner">
    <div class="team-copy">
      <div class="section-head">
        <p class="eyebrow"><?php esc_html_e( 'Your team', 'zenterra' ); ?></p>
        <h2><?php esc_html_e( "Who you'll work with", 'zenterra' ); ?></h2>
        <p class="section-lead"><?php esc_html_e( 'You work directly with our team lead, a senior developer with many years of experience building websites and web apps for international clients, from company sites to MVPs.', 'zenterra' ); ?></p>
      </div>
      <p><?php esc_html_e( 'We build with AI tools like Claude, Cursor and ChatGPT, and bring in trusted developers when a project needs more hands. The team lead sets the architecture, writes the specifications and personally reviews every change before it goes live.', 'zenterra' ); ?></p>
      <p><?php esc_html_e( "You talk to the person responsible for your project: no account managers, no hand-offs. If something can be done simpler or cheaper, we'll tell you.", 'zenterra' ); ?></p>
      <ul class="checks">
        <li><?php esc_html_e( 'Direct communication in English and Ukrainian', 'zenterra' ); ?></li>
        <li><?php esc_html_e( 'Every pull request reviewed personally by the team lead', 'zenterra' ); ?></li>
        <li><?php esc_html_e( 'Working hours that overlap with the whole European workday', 'zenterra' ); ?></li>
      </ul>
      <a href="<?php echo esc_url( ZENTERRA_LINKEDIN ); ?>" class="btn btn-ghost" target="_blank" rel="noopener"><svg class="li-icon" viewBox="0 0 24 24" aria-hidden="true"><path d="M4.98 3.5a2.5 2.5 0 1 1 0 5 2.5 2.5 0 0 1 0-5zM3 9.5h4V21H3zM9.5 9.5h3.8v1.6h.06c.53-1 1.83-2.06 3.77-2.06 4.03 0 4.77 2.65 4.77 6.1V21h-4v-5.1c0-1.22-.02-2.78-1.7-2.78-1.7 0-1.96 1.33-1.96 2.7V21h-4z"/></svg><?php esc_html_e( 'Zenterra IT on LinkedIn', 'zenterra' ); ?></a>
    </div>

    <aside class="card team-card" aria-label="<?php esc_attr_e( 'Team lead', 'zenterra' ); ?>">
      <div class="team-avatar"><svg class="team-mark" viewBox="9 11 46 42" aria-hidden="true"><defs><linearGradient id="zt-mark-team" x1="12" y1="10" x2="52" y2="54" gradientUnits="userSpaceOnUse"><stop stop-color="#B9B9B9"/><stop offset="1" stop-color="#5C16FF"/></linearGradient></defs><g fill="url(#zt-mark-team)"><rect x="10" y="25" width="6" height="14" rx="3"/><rect x="19.5" y="18" width="6" height="28" rx="3"/><rect x="29" y="12" width="6" height="40" rx="3"/><rect x="38.5" y="20" width="6" height="24" rx="3"/><rect x="48" y="26" width="6" height="12" rx="3"/></g></svg></div>
      <p class="team-role"><?php esc_html_e( 'Team lead', 'zenterra' ); ?></p>
      <p class="muted"><?php esc_html_e( 'Senior developer', 'zenterra' ); ?> · Zenterra IT</p>
      <dl class="team-facts">
        <div><dt><?php esc_html_e( 'Stack', 'zenterra' ); ?></dt><dd>React · Next.js · Node.js · WordPress</dd></div>
        <div><dt><?php esc_html_e( 'Languages', 'zenterra' ); ?></dt><dd><?php esc_html_e( 'English, Ukrainian', 'zenterra' ); ?></dd></div>
        <div><dt><?php esc_html_e( 'Code review', 'zenterra' ); ?></dt><dd><?php esc_html_e( 'Every change, personally', 'zenterra' ); ?></dd></div>
      </dl>
    </aside>
  </div>
</section>

<!-- FAQ -->
<section class="section" id="faq">
  <div class="container narrow">
    <div class="section-head">
      <p class="eyebrow"><?php esc_html_e( 'FAQ', 'zenterra' ); ?></p>
      <h2><?php esc_html_e( 'Common questions', 'zenterra' ); ?></h2>
    </div>
    <div class="faq">
      <details>
        <summary><?php esc_html_e( 'Is it just AI doing the work?', 'zenterra' ); ?></summary>
        <p><?php esc_html_e( 'No. We\'re professional developers with many years of experience behind us. AI speeds up routine work like boilerplate, first drafts and tests. Architecture, decisions, code review and responsibility for the result stay with people. You get experienced developers who are faster, not a chatbot with a price list.', 'zenterra' ); ?></p>
      </details>
      <details>
        <summary><?php esc_html_e( 'Why a fixed price instead of hourly?', 'zenterra' ); ?></summary>
        <p><?php esc_html_e( 'You pay for the result, not for time. With AI tools, work that used to take 40 hours might take 15. Hourly billing would hide that. A fixed price gives you a clear number up front and gives us a reason to stay efficient.', 'zenterra' ); ?></p>
      </details>
      <details>
        <summary><?php esc_html_e( 'Will AI-written code be good enough?', 'zenterra' ); ?></summary>
        <p><?php esc_html_e( 'Every change goes through automated checks and is then reviewed by our team lead against the spec and our launch checklist. AI speeds up the work, and an experienced developer is responsible for the quality.', 'zenterra' ); ?></p>
      </details>
      <details>
        <summary><?php esc_html_e( 'Who owns the website and code?', 'zenterra' ); ?></summary>
        <p><?php esc_html_e( 'You do. All rights to the work transfer to you once it\'s paid for. Your site, hosting and API keys stay on your own accounts from day one.', 'zenterra' ); ?></p>
      </details>
      <details>
        <summary><?php esc_html_e( 'Which platform should I choose: WordPress, Next.js, Astro or Webflow?', 'zenterra' ); ?></summary>
        <p><?php esc_html_e( 'WordPress is the flexible all-rounder with a huge plugin ecosystem, great for content-heavy sites, blogs and WooCommerce stores. Webflow suits teams that want to edit visually without a developer. Next.js and Astro are best for custom functionality, speed and deeper integrations. We\'ll recommend one during the brief.', 'zenterra' ); ?></p>
      </details>
      <details>
        <summary><?php esc_html_e( 'What happens if I need changes beyond the two revision rounds?', 'zenterra' ); ?></summary>
        <p><?php esc_html_e( 'We send a short change request with its own price and timeline. Nothing is added to your bill without your approval.', 'zenterra' ); ?></p>
      </details>
      <details>
        <summary><?php esc_html_e( 'How do I pay?', 'zenterra' ); ?></summary>
        <p><?php esc_html_e( 'We invoice in USD. Websites are 50% upfront and 50% at launch. Larger projects are paid by milestone. Payment is by international bank transfer (SWIFT), or through Upwork if we\'re working there.', 'zenterra' ); ?></p>
      </details>
      <details>
        <summary><?php esc_html_e( 'Where are your clients?', 'zenterra' ); ?></summary>
        <p><?php esc_html_e( 'We work with small businesses, startups and agencies internationally: across Europe, including Ukraine and Poland, and beyond.', 'zenterra' ); ?></p>
      </details>
    </div>
  </div>
</section>

<!-- Contact -->
<section class="section section-alt" id="contact">
  <div class="container contact-inner">
    <div>
      <p class="eyebrow"><?php esc_html_e( 'Start a project', 'zenterra' ); ?></p>
      <h2><?php esc_html_e( 'Tell us what you need', 'zenterra' ); ?></h2>
      <p class="section-lead"><?php esc_html_e( 'Answer a few questions and we\'ll reply within 24–48 hours with a scope, a timeline and a fixed price.', 'zenterra' ); ?></p>
      <ul class="contact-points">
        <li><span class="muted"><?php esc_html_e( 'Email', 'zenterra' ); ?></span><a href="mailto:<?php echo esc_attr( antispambot( $contact_email ) ); ?>"><?php echo esc_html( antispambot( $contact_email ) ); ?></a></li>
        <li><span class="muted">Telegram</span><a href="<?php echo esc_url( 'https://t.me/' . ZENTERRA_TELEGRAM ); ?>" target="_blank" rel="noopener">@<?php echo esc_html( ZENTERRA_TELEGRAM ); ?></a></li>
        <li><span class="muted">LinkedIn</span><a href="<?php echo esc_url( ZENTERRA_LINKEDIN ); ?>" target="_blank" rel="noopener">Zenterra IT</a></li>
        <li><span class="muted"><?php esc_html_e( 'Response', 'zenterra' ); ?></span><?php esc_html_e( 'Within 24–48 hours', 'zenterra' ); ?></li>
        <li><span class="muted">NDA</span><?php esc_html_e( 'Available on request', 'zenterra' ); ?></li>
      </ul>
      <div class="call-cta">
        <p class="muted"><?php esc_html_e( 'Prefer to talk first? Pick a time that suits you.', 'zenterra' ); ?></p>
        <a href="<?php echo esc_url( ZENTERRA_CALENDLY ); ?>" class="btn btn-ghost" target="_blank" rel="noopener"><svg class="btn-icon" viewBox="0 0 24 24" aria-hidden="true"><rect x="3.5" y="5" width="17" height="15" rx="2.5"/><path d="M3.5 10h17M8 3v4M16 3v4"/></svg><?php esc_html_e( 'Book a free 30-min call', 'zenterra' ); ?></a>
      </div>
    </div>

    <form class="card form" id="contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate>
      <input type="hidden" name="action" value="zenterra_contact">
      <input type="hidden" name="lang" value="<?php echo esc_attr( zenterra_lang() ); ?>">
      <div class="hp" aria-hidden="true">
        <input name="website" type="text" tabindex="-1" autocomplete="off" aria-hidden="true">
      </div>
      <div class="field-row">
        <label><?php esc_html_e( 'Name', 'zenterra' ); ?><input name="name" type="text" autocomplete="name" required></label>
        <label><?php esc_html_e( 'Email', 'zenterra' ); ?><input name="email" type="email" autocomplete="email" required></label>
      </div>
      <label><?php esc_html_e( 'What do you need?', 'zenterra' ); ?>
        <select name="topic">
          <?php foreach ( zenterra_contact_topics() as $topic ) : ?>
            <option value="<?php echo esc_attr( $topic ); ?>"<?php selected( $topic, 'Company website' ); ?>><?php echo esc_html( __( $topic, 'zenterra' ) ); // phpcs:ignore WordPress.WP.I18n ?></option>
          <?php endforeach; ?>
        </select>
      </label>
      <label><?php esc_html_e( 'About your business and goal', 'zenterra' ); ?>
        <textarea name="goal" rows="3" placeholder="<?php esc_attr_e( 'Who is it for, and what should happen because of it: leads, sales, trust?', 'zenterra' ); ?>" required></textarea>
      </label>
      <label><?php esc_html_e( 'Sites you like', 'zenterra' ); ?> <span class="opt"><?php esc_html_e( '(optional)', 'zenterra' ); ?></span>
        <input name="examples" type="text" placeholder="<?php esc_attr_e( 'Links and what you like about them', 'zenterra' ); ?>">
      </label>
      <div class="field-row">
        <label><?php esc_html_e( 'Budget', 'zenterra' ); ?>
          <select name="budget">
            <?php foreach ( zenterra_contact_budgets( zenterra_lang() ) as $i => $budget ) : ?>
              <option value="<?php echo esc_attr( $budget ); ?>"<?php selected( $i, 1 ); ?>><?php echo esc_html( $budget ); ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <label><?php esc_html_e( 'Deadline', 'zenterra' ); ?> <span class="opt"><?php esc_html_e( '(optional)', 'zenterra' ); ?></span>
          <input name="deadline" type="text" placeholder="<?php esc_attr_e( 'e.g. end of November', 'zenterra' ); ?>">
        </label>
      </div>
      <button type="submit" class="btn btn-primary btn-block"><?php esc_html_e( 'Send request', 'zenterra' ); ?></button>
      <p class="form-note small<?php echo esc_attr( $status_class ); ?>" id="form-note" role="status" aria-live="polite"><?php echo esc_html( $status_text ); ?></p>
      <p class="form-consent small muted"><?php
        /* translators: %s: link to the privacy policy */
        printf( esc_html__( 'By sending this form, you agree to %s. We reply within 24–48 hours.', 'zenterra' ), '<a href="' . esc_url( zenterra_privacy_url() ) . '">' . esc_html__( 'our Privacy Policy', 'zenterra' ) . '</a>' );
      ?></p>
    </form>
  </div>
</section>
</main>

<?php
get_footer();
