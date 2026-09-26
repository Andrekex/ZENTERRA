<?php
/**
 * Homepage: the full one-page layout.
 */

$contact_email = zenterra_contact_email();

$statuses = array(
	'sent'    => array( ' success', "Thanks! Your request is on its way. We'll reply within 24–48 hours." ),
	'invalid' => array( ' error', 'Please fill in your name, a valid email and your goal.' ),
	'limit'   => array( ' error', 'Too many requests from your network. Please email us directly.' ),
	'error'   => array( ' error', "Sorry, the message couldn't be sent. Please email us directly." ),
);
$status = isset( $_GET['contact'] ) ? sanitize_key( wp_unslash( $_GET['contact'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
list( $status_class, $status_text ) = isset( $statuses[ $status ] )
	? $statuses[ $status ]
	: array( ' muted', "We'll reply within 24–48 hours." );

get_header();
?>

<main id="main">
<!-- Hero -->
<section class="hero" id="top">
  <span class="hero-blob" aria-hidden="true"></span>
  <div class="container hero-inner">
    <p class="eyebrow">AI-powered development studio</p>
    <h1><span class="w"><span>Experienced</span></span> <span class="w"><span>developers,</span></span> <span class="w"><span>powered</span></span> <span class="w"><span>by</span></span> <span class="w"><span>AI.</span></span><br><span class="w accent-w"><span class="accent">Every line reviewed.</span></span></h1>
    <p class="lead">We're professional developers with many years of experience behind us. AI makes us faster, but it's experience that solves your business problem. Fixed price, honest estimates, and every change reviewed by an experienced developer before it reaches you.</p>
    <div class="hero-cta">
      <a href="#contact" class="btn btn-primary">Get a proposal in 48 hours</a>
      <a href="#pricing" class="btn btn-ghost">See pricing</a>
    </div>
    <dl class="stats">
      <div><dt>1–2 weeks</dt><dd>for a typical company website</dd></div>
      <div><dt>Fixed price</dt><dd>agreed before work starts</dd></div>
      <div><dt>Real experience</dt><dd>professional developers, not prompt operators</dd></div>
      <div><dt>100% reviewed</dt><dd>every pull request, by a human</dd></div>
    </dl>
  </div>

  <div class="marquee" aria-hidden="true">
    <div class="marquee-track">
      <span>WordPress</span><span>Next.js</span><span>React</span><span>React Native</span><span>Node.js</span><span>NestJS</span><span>TypeScript</span><span>JavaScript</span><span>Wix Studio</span><span>Webflow</span><span>LLM APIs</span><span>iOS & Android</span><span>WordPress</span><span>Next.js</span><span>React</span><span>React Native</span><span>Node.js</span><span>NestJS</span><span>TypeScript</span><span>JavaScript</span><span>Wix Studio</span><span>Webflow</span><span>LLM APIs</span><span>iOS & Android</span>
    </div>
    <div class="marquee-track reverse">
      <span>Landing pages</span><span>Company websites</span><span>Online stores</span><span>Redesigns</span><span>AI chatbots</span><span>Automation</span><span>Web apps</span><span>Mobile apps</span><span>MVPs</span><span>Website support</span><span>Landing pages</span><span>Company websites</span><span>Online stores</span><span>Redesigns</span><span>AI chatbots</span><span>Automation</span><span>Web apps</span><span>Mobile apps</span><span>MVPs</span><span>Website support</span>
    </div>
  </div>
</section>

<!-- Why -->
<section class="section" id="why">
  <div class="container">
    <div class="section-head">
      <p class="eyebrow">Why Zenterra</p>
      <h2>Agency-grade quality at a freelancer's pace</h2>
      <p class="section-lead">Big agencies are reliable but slow and expensive. Solo freelancers are cheaper but unpredictable. We sit in between: a small team of experienced developers who use AI for speed, with a team lead who answers for quality.</p>
    </div>
    <div class="table-wrap">
      <table class="compare">
        <thead>
          <tr><th scope="col"></th><th scope="col">Typical agency</th><th scope="col">Freelancer</th><th scope="col" class="hl">Zenterra</th></tr>
        </thead>
        <tbody>
          <tr><th scope="row">Website price</th><td>from $1,500–3,500</td><td>cheaper</td><td class="hl">$1,500–4,000, fixed</td></tr>
          <tr><th scope="row">Timeline</th><td>weeks</td><td>unpredictable</td><td class="hl">1–2 weeks for a typical site</td></tr>
          <tr><th scope="row">Team</th><td>seniors + account manager</td><td>one person</td><td class="hl">experienced developers, accelerated by AI</td></tr>
          <tr><th scope="row">Quality control</th><td>senior review</td><td>none</td><td class="hl">every PR reviewed + launch checklist</td></tr>
        </tbody>
      </table>
    </div>
    <div class="callout">
      <strong>You don't buy prompts.</strong> You buy a finished website or solution, a deadline and a quality guarantee. Our prompts, templates and checklists are internal tools that make the team fast and consistent.
    </div>

    <div class="principles">
      <h3 class="h-small">What we stand for</h3>
      <div class="principles-grid">
        <div class="card principle">
          <span class="principle-n">01</span>
          <h4>Experience first, AI second</h4>
          <p>AI is a tool in experienced hands. We were building and shipping software long before AI coding assistants existed, and we know where they help and where they fail.</p>
        </div>
        <div class="card principle">
          <span class="principle-n">02</span>
          <h4>Real business problems</h4>
          <p>We start from what you need to change, whether that's more leads, less manual work or a faster site, not from the technology we'd like to sell.</p>
        </div>
        <div class="card principle">
          <span class="principle-n">03</span>
          <h4>Honest estimates</h4>
          <p>If a project needs more time or budget, we tell you before you sign, not halfway through. The price we quote is the price you pay.</p>
        </div>
        <div class="card principle">
          <span class="principle-n">04</span>
          <h4>No hype, no lies</h4>
          <p>We tell you what AI can and can't do for you. If a ready-made tool solves your problem for less, we'll say so.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Services -->
<section class="section section-alt" id="services">
  <div class="container">
    <div class="section-head">
      <p class="eyebrow">Services</p>
      <h2>What we build</h2>
    </div>
    <div class="grid-3">
      <article class="card service">
        <div class="service-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M3 9h18M7 6.5h.01M10 6.5h.01"/></svg>
        </div>
        <h3>Websites</h3>
        <p class="muted">On WordPress, Next.js, Wix Studio or Webflow.</p>
        <ul class="checks">
          <li>Landing pages and company websites</li>
          <li>Custom WordPress themes and plugins</li>
          <li>Redesigns and migrations from Squarespace, older WordPress sites and more</li>
          <li>Simple online stores</li>
          <li>Multilingual sites, animations and integrations</li>
          <li>Monthly support and updates</li>
        </ul>
      </article>
      <article class="card service">
        <div class="service-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24"><path d="M12 3l1.8 4.6L18.5 9l-4.7 1.4L12 15l-1.8-4.6L5.5 9l4.7-1.4z"/><path d="M18 15l.9 2.1L21 18l-2.1.9L18 21l-.9-2.1L15 18l2.1-.9z"/></svg>
        </div>
        <h3>AI solutions</h3>
        <p class="muted">Built with leading AI models, designed and reviewed in-house.</p>
        <ul class="checks">
          <li>Chatbots and assistants trained on your own knowledge base (RAG)</li>
          <li>Automated handling of leads, requests and documents</li>
          <li>Integrations with your CRM and leading AI model APIs</li>
          <li>AI audit: where AI will pay off in your business, with a prototype</li>
        </ul>
      </article>
      <article class="card service">
        <div class="service-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24"><rect x="7" y="2.5" width="10" height="19" rx="2.5"/><path d="M11 18.5h2"/></svg>
        </div>
        <h3>Apps &amp; MVPs</h3>
        <p class="muted">For startups that need a first version fast.</p>
        <ul class="checks">
          <li>Web apps in React and Next.js</li>
          <li>Mobile apps for iOS and Android with React Native</li>
          <li>Backends and APIs in Node.js and NestJS</li>
          <li>MVPs with AI features built in</li>
          <li>Projects typically from $3,000, quoted after a short scoping call</li>
        </ul>
      </article>
    </div>

    <div class="stack">
      <h3 class="h-small">Our stack</h3>
      <dl class="stack-grid">
        <div><dt>Frontend</dt><dd>HTML</dd><dd>CSS</dd><dd>JavaScript</dd><dd>TypeScript</dd><dd>React</dd><dd>Next.js</dd></div>
        <div><dt>Backend</dt><dd>Node.js</dd><dd>NestJS</dd><dd>REST APIs</dd></div>
        <div><dt>Mobile</dt><dd>React Native</dd><dd>iOS</dd><dd>Android</dd></div>
        <div><dt>CMS &amp; builders</dt><dd>WordPress</dd><dd>Wix Studio</dd><dd>Webflow</dd></div>
        <div><dt>AI</dt><dd>LLM APIs</dd><dd>RAG</dd><dd>AI automation</dd></div>
      </dl>
    </div>
    <div class="audiences">
      <h3 class="h-small">Who we work with</h3>
      <ul class="chips">
        <li>Small businesses in the US and EU</li>
        <li>Startups that need an MVP or AI features</li>
        <li>Agencies that need extra hands</li>
        <li>Businesses in Ukraine and Poland</li>
      </ul>
    </div>
  </div>
</section>

<!-- Pricing -->
<section class="section" id="pricing">
  <div class="container">
    <div class="section-head">
      <p class="eyebrow">Pricing</p>
      <h2>Clear scope. Fixed price.</h2>
      <p class="section-lead">Every project gets a written scope, a timeline and one price. No hourly surprises.</p>
    </div>

    <div class="tabs" role="tablist" aria-label="Pricing category">
      <button role="tab" id="tab-web" aria-selected="true" aria-controls="panel-web" type="button">Websites</button>
      <button role="tab" id="tab-ai" aria-selected="false" aria-controls="panel-ai" type="button" tabindex="-1">AI solutions</button>
    </div>

    <div class="price-grid" id="panel-web" role="tabpanel" aria-labelledby="tab-web">
      <article class="card price">
        <h3>Landing page</h3>
        <p class="price-tag">$800–1,500</p>
        <p class="price-time">3–5 days</p>
        <p class="muted">One page, responsive, forms and basic SEO.</p>
      </article>
      <article class="card price featured">
        <span class="badge">Most popular</span>
        <h3>Company website</h3>
        <p class="price-tag">$1,500–2,500</p>
        <p class="price-time">1–2 weeks</p>
        <p class="muted">5–8 pages, CMS or blog, forms and basic SEO.</p>
      </article>
      <article class="card price">
        <h3>Advanced website</h3>
        <p class="price-tag">$3,500–6,000</p>
        <p class="price-time">2–4 weeks</p>
        <p class="muted">Animations, integrations, multiple languages, online store.</p>
      </article>
      <article class="card price">
        <h3>Redesign / migration</h3>
        <p class="price-tag">$1,500–3,000</p>
        <p class="price-time">1–2 weeks</p>
        <p class="muted">Move from WordPress, Squarespace and others, with a fresh design.</p>
      </article>
      <article class="card price">
        <h3>Website support</h3>
        <p class="price-tag">$100–300<small>/mo</small></p>
        <p class="price-time">Monthly</p>
        <p class="muted">Edits, updates and uptime checks.</p>
      </article>
    </div>

    <div class="price-grid" id="panel-ai" role="tabpanel" aria-labelledby="tab-ai" hidden>
      <article class="card price featured">
        <span class="badge">Start here</span>
        <h3>AI audit</h3>
        <p class="price-tag">$800–1,500</p>
        <p class="price-time">1 week</p>
        <p class="muted">Where AI will make a difference in your business, plus a working prototype.</p>
      </article>
      <article class="card price">
        <h3>AI chatbot / assistant</h3>
        <p class="price-tag">$1,500–5,000</p>
        <p class="price-time">1–3 weeks</p>
        <p class="muted">A bot that answers from your own knowledge base, embedded in your site.</p>
      </article>
      <article class="card price">
        <h3>AI automation</h3>
        <p class="price-tag">$2,000–8,000</p>
        <p class="price-time">2–4 weeks</p>
        <p class="muted">Processing leads and documents, CRM integrations, built on leading AI models.</p>
      </article>
    </div>

    <div class="terms">
      <h3 class="h-small">How payment works</h3>
      <ul class="terms-list">
        <li><strong>50% upfront</strong> for websites; larger projects are paid 30–50% upfront, then by milestone.</li>
        <li><strong>2 revision rounds</strong> are included. Anything outside scope becomes a separate, priced change request.</li>
        <li><strong>Your accounts, your assets.</strong> Your Wix plan, hosting and AI API usage run on your own accounts.</li>
        <li><strong>You own the result.</strong> All rights to the work transfer to you once it's paid for.</li>
        <li><strong>Consultations</strong> are available by the hour, from $30–40/hour.</li>
      </ul>
    </div>
  </div>
</section>

<!-- Process -->
<section class="section section-alt" id="process">
  <div class="container">
    <div class="section-head">
      <p class="eyebrow">Process</p>
      <h2>From first message to launch</h2>
    </div>
    <ol class="steps">
      <li><span class="step-n">1</span><div><h3>Request</h3><p>Reach out through the form, Upwork or LinkedIn.</p></div></li>
      <li><span class="step-n">2</span><div><h3>Brief</h3><p>One call or a short form: goals, pages, examples you like, content and access.</p></div></li>
      <li><span class="step-n">3</span><div><h3>Proposal</h3><p>Scope, timeline and fixed price within 24–48 hours.</p></div></li>
      <li><span class="step-n">4</span><div><h3>50% deposit</h3><p>We lock in the schedule and start work.</p></div></li>
      <li><span class="step-n">5</span><div><h3>Structure</h3><p>Sitemap, sections and design direction in 1–2 days.</p></div></li>
      <li><span class="step-n">6</span><div><h3>Build</h3><p>Built by experienced developers with AI assistance, from tested templates, on a staging site, in 3–10 days.</p></div></li>
      <li><span class="step-n">7</span><div><h3>Team lead review</h3><p>Every change is checked against our launch checklist.</p></div></li>
      <li><span class="step-n">8</span><div><h3>Demo &amp; revisions</h3><p>You see the result and we do two rounds of revisions.</p></div></li>
      <li><span class="step-n">9</span><div><h3>Launch</h3><p>Live on your domain with analytics connected. The remaining 50% is due.</p></div></li>
      <li><span class="step-n">10</span><div><h3>Support</h3><p>Optional monthly care from $100/month.</p></div></li>
    </ol>
  </div>
</section>

<!-- AI-first cycle + DoD -->
<section class="section" id="quality">
  <div class="container">
    <div class="section-head">
      <p class="eyebrow">How we build</p>
      <h2>AI does the work. People are accountable for it.</h2>
      <p class="section-lead">AI makes experienced developers faster. Our process makes that speed safe to rely on.</p>
    </div>
    <ol class="cycle">
      <li><span class="who who-human">Human</span><h3>Specification</h3><p>Goal, acceptance criteria and what not to do. No spec, no code.</p></li>
      <li><span class="who who-human">Human</span><h3>Context</h3><p>Every repository has project conventions, commands and section templates.</p></li>
      <li><span class="who who-ai">AI</span><h3>Implementation</h3><p>Plan first, approved by the lead, then small changes.</p></li>
      <li><span class="who who-ai">Automated</span><h3>Checks</h3><p>Linters, build, tests, page speed and accessibility checks.</p></li>
      <li><span class="who who-human">Human</span><h3>Review</h3><p>Every PR: logic, security, responsiveness and matching the spec.</p></li>
      <li><span class="who who-human">Human</span><h3>Demo</h3><p>You see the result; lessons learned feed back into our playbook.</p></li>
    </ol>

    <div class="grid-2 quality-grid">
      <div class="card">
        <h3>Launch checklist</h3>
        <p class="muted">A site isn't done until every box is ticked.</p>
        <ul class="checks">
          <li>Spec delivered, both revision rounds closed</li>
          <li>Responsive on phone, tablet and desktop</li>
          <li>Forms work and submissions arrive</li>
          <li>Page speed and basic SEO: headings, meta tags, sitemap</li>
          <li>No keys or secrets in the code</li>
          <li>Analytics and domain connected</li>
          <li>Team lead review passed</li>
          <li>You receive all access and a short how-to guide</li>
        </ul>
      </div>
      <div class="card">
        <h3>Security &amp; your data</h3>
        <p class="muted">We treat your code and data carefully.</p>
        <ul class="checks">
          <li>Client code is handled only in business-grade AI workspaces, where model training on your data is switched off.</li>
          <li>Under our AI providers' commercial terms, you own everything we produce for you.</li>
          <li>Separate access for every project, kept in a password manager and revoked when the project ends.</li>
          <li>NDA available on request, and a DPA for EU personal data.</li>
          <li>Backup power and internet for everyone on the team, so work continues during outages.</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Agencies -->
<section class="section section-dark" id="agencies">
  <div class="container agencies-inner">
    <div>
      <p class="eyebrow">For agencies</p>
      <h2>Your brand. Our team. Fixed price.</h2>
      <p class="section-lead">Too many orders and not enough people? You handle sales and the client relationship. We build websites on WordPress, Next.js, Wix Studio or Webflow, plus apps and AI integrations, under your brand.</p>
      <ul class="checks">
        <li>White-label delivery, with no contact with your clients unless you want it</li>
        <li>Fixed price per project, so your margin is predictable</li>
        <li>The same review process and launch checklist on every site</li>
        <li>Your first task comes at a discount</li>
      </ul>
      <a href="#contact" class="btn btn-primary" data-topic="White-label partnership">Talk about a partnership</a>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="section" id="faq">
  <div class="container narrow">
    <div class="section-head">
      <p class="eyebrow">FAQ</p>
      <h2>Common questions</h2>
    </div>
    <div class="faq">
      <details>
        <summary>Is it just AI doing the work?</summary>
        <p>No. We're professional developers with many years of experience behind us. AI speeds up routine work like boilerplate, first drafts and tests. Architecture, decisions, code review and responsibility for the result stay with people. You get experienced developers who are faster, not a chatbot with a price list.</p>
      </details>
      <details>
        <summary>Why a fixed price instead of hourly?</summary>
        <p>You pay for the result, not for time. With AI tools, work that used to take 40 hours might take 15. Hourly billing would hide that. A fixed price gives you a clear number up front and gives us a reason to stay efficient.</p>
      </details>
      <details>
        <summary>Will AI-written code be good enough?</summary>
        <p>Every change goes through automated checks and is then reviewed by our team lead against the spec and our launch checklist. AI speeds up the work, and an experienced developer is responsible for the quality.</p>
      </details>
      <details>
        <summary>Who owns the website and code?</summary>
        <p>You do. All rights to the work transfer to you once it's paid for. Your site, hosting and API keys stay on your own accounts from day one.</p>
      </details>
      <details>
        <summary>Which platform should I choose: WordPress, Next.js, Wix Studio or Webflow?</summary>
        <p>WordPress is the flexible all-rounder with a huge plugin ecosystem, great for content-heavy sites and blogs. Wix Studio and Webflow suit teams that want to edit visually without a developer. Next.js is best for custom functionality, speed and deeper integrations. We'll recommend one during the brief.</p>
      </details>
      <details>
        <summary>What happens if I need changes beyond the two revision rounds?</summary>
        <p>We send a short change request with its own price and timeline. Nothing is added to your bill without your approval.</p>
      </details>
      <details>
        <summary>How do I pay?</summary>
        <p>We invoice in USD. Websites are 50% upfront and 50% at launch. Larger projects are paid by milestone. Payment is by international bank transfer (SWIFT), or through Upwork if we're working there.</p>
      </details>
      <details>
        <summary>Do you work with clients outside the US?</summary>
        <p>Yes. We work with small businesses and startups across the US and EU, plus Ukraine and Poland.</p>
      </details>
    </div>
  </div>
</section>

<!-- Contact -->
<section class="section section-alt" id="contact">
  <div class="container contact-inner">
    <div>
      <p class="eyebrow">Start a project</p>
      <h2>Tell us what you need</h2>
      <p class="section-lead">Answer a few questions and we'll reply within 24–48 hours with a scope, a timeline and a fixed price.</p>
      <ul class="contact-points">
        <li><span class="muted">Email</span><a href="mailto:<?php echo esc_attr( antispambot( $contact_email ) ); ?>"><?php echo esc_html( antispambot( $contact_email ) ); ?></a></li>
        <li><span class="muted">Response</span>Within 24–48 hours</li>
        <li><span class="muted">NDA</span>Available on request</li>
      </ul>
    </div>

    <form class="card form" id="contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate>
      <input type="hidden" name="action" value="zenterra_contact">
      <div class="hp" aria-hidden="true">
        <label>Leave this empty<input name="website" type="text" tabindex="-1" autocomplete="off"></label>
      </div>
      <div class="field-row">
        <label>Name<input name="name" type="text" autocomplete="name" required></label>
        <label>Email<input name="email" type="email" autocomplete="email" required></label>
      </div>
      <label>What do you need?
        <select name="topic">
          <?php foreach ( zenterra_contact_topics() as $topic ) : ?>
            <option<?php selected( $topic, 'Company website' ); ?>><?php echo esc_html( $topic ); ?></option>
          <?php endforeach; ?>
        </select>
      </label>
      <label>About your business and goal
        <textarea name="goal" rows="3" placeholder="Who is it for, and what should happen because of it: leads, sales, trust?" required></textarea>
      </label>
      <label>Sites you like <span class="opt">(optional)</span>
        <input name="examples" type="text" placeholder="Links and what you like about them">
      </label>
      <div class="field-row">
        <label>Budget
          <select name="budget">
            <?php foreach ( zenterra_contact_budgets() as $budget ) : ?>
              <option<?php selected( $budget, '$1,500–3,000' ); ?>><?php echo esc_html( $budget ); ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <label>Deadline <span class="opt">(optional)</span>
          <input name="deadline" type="text" placeholder="e.g. end of November">
        </label>
      </div>
      <button type="submit" class="btn btn-primary btn-block">Send request</button>
      <p class="form-note small<?php echo esc_attr( $status_class ); ?>" id="form-note" role="status" aria-live="polite"><?php echo esc_html( $status_text ); ?></p>
    </form>
  </div>
</section>
</main>

<?php
get_footer();
