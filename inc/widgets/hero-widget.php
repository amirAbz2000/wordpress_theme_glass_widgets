<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Personal_Site_Hero_Widget extends \Elementor\Widget_Base {

    public function get_name(): string        { return 'personal_site_hero'; }
    public function get_title(): string       { return esc_html__( 'Hero Section', 'personal-site' ); }
    public function get_icon(): string        { return 'eicon-header'; }
    public function get_categories(): array   { return [ 'personal-site' ]; }
    public function get_keywords(): array     { return [ 'hero', 'banner', 'freelancer', 'portfolio' ]; }

    public function get_style_depends(): array {
        return [ 'personal-site-hero-widget' ];
    }

    protected function register_controls(): void {

        // ── Content ──────────────────────────────────────────────────
        $this->start_controls_section( 'section_content', [
            'label' => esc_html__( 'Content', 'personal-site' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'badge_text', [
            'label'       => esc_html__( 'Badge Text', 'personal-site' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => esc_html__( 'Freelance available globally.', 'personal-site' ),
            'placeholder' => esc_html__( 'e.g. Open for work', 'personal-site' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => esc_html__( 'Heading', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => esc_html__( 'Creative Solutions That Drive Real Results', 'personal-site' ),
            'rows'    => 3,
        ] );

        $this->add_control( 'subheading', [
            'label'   => esc_html__( 'Sub-heading / Description', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => esc_html__( 'I design and build digital experiences that connect with people.', 'personal-site' ),
            'rows'    => 3,
        ] );

        $this->add_control( 'cta_primary_text', [
            'label'   => esc_html__( "Primary CTA Text", 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__( "Let's Connect →", 'personal-site' ),
        ] );

        $this->add_control( 'cta_primary_url', [
            'label'   => esc_html__( 'Primary CTA URL', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '#contact' ],
        ] );

        $this->add_control( 'cta_secondary_text', [
            'label'   => esc_html__( 'Secondary CTA Text', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__( 'View Work', 'personal-site' ),
        ] );

        $this->add_control( 'cta_secondary_url', [
            'label'   => esc_html__( 'Secondary CTA URL', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::URL,
            'default' => [ 'url' => '#work' ],
        ] );

        $this->add_control( 'availability_text', [
            'label'   => esc_html__( 'Availability Label', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__( 'Available for new projects', 'personal-site' ),
        ] );

        $this->add_control( 'avatar_image', [
            'label'   => esc_html__( 'Avatar / Hero Image', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
        ] );

        $this->end_controls_section();

        // ── Social Proof ─────────────────────────────────────────────
        $this->start_controls_section( 'section_social_proof', [
            'label' => esc_html__( 'Social Proof', 'personal-site' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control( 'avatar', [
            'label' => esc_html__( 'Avatar', 'personal-site' ),
            'type'  => \Elementor\Controls_Manager::MEDIA,
        ] );

        $repeater->add_control( 'name', [
            'label'   => esc_html__( 'Name', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Client Name',
        ] );

        $this->add_control( 'social_proof_avatars', [
            'label'       => esc_html__( 'Client Avatars', 'personal-site' ),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [ 'name' => 'Client 1' ],
                [ 'name' => 'Client 2' ],
                [ 'name' => 'Client 3' ],
            ],
            'title_field' => '{{{ name }}}',
        ] );

        $this->add_control( 'social_proof_text', [
            'label'   => esc_html__( 'Social Proof Text', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__( 'Loved by founders globally', 'personal-site' ),
        ] );

        $this->add_control( 'star_rating', [
            'label'   => esc_html__( 'Star Rating (1–5)', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'min'     => 1,
            'max'     => 5,
            'default' => 5,
        ] );

        $this->end_controls_section();

        // ── Style: Colors ─────────────────────────────────────────────
        $this->start_controls_section( 'section_style', [
            'label' => esc_html__( 'Style', 'personal-site' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'accent_color', [
            'label'     => esc_html__( 'Accent Color', 'personal-site' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'oklch(65% 0.20 52)',
            'selectors' => [
                '{{WRAPPER}} .ps-hero__badge'       => 'border-color: {{VALUE}}; color: {{VALUE}};',
                '{{WRAPPER}} .ps-hero__cta--primary' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .ps-hero__avatar-wrap'  => 'box-shadow: 0 0 80px 20px {{VALUE}}33;',
                '{{WRAPPER}} .ps-hero__avail-dot'    => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .ps-hero__stars'        => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'heading_color', [
            'label'     => esc_html__( 'Heading Color', 'personal-site' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => '#ffffff',
            'selectors' => [
                '{{WRAPPER}} .ps-hero__heading' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'bg_color', [
            'label'     => esc_html__( 'Background Color', 'personal-site' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'oklch(12% 0.01 60)',
            'selectors' => [
                '{{WRAPPER}} .ps-hero' => 'background-color: {{VALUE}};',
            ],
        ] );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'heading_typography',
                'label'    => esc_html__( 'Heading Typography', 'personal-site' ),
                'selector' => '{{WRAPPER}} .ps-hero__heading',
            ]
        );

        $this->end_controls_section();
    }

    protected function render(): void {
        $s          = $this->get_settings_for_display();
        $primary_url = isset( $s['cta_primary_url']['url'] ) ? esc_url( $s['cta_primary_url']['url'] ) : '#';
        $secondary_url = isset( $s['cta_secondary_url']['url'] ) ? esc_url( $s['cta_secondary_url']['url'] ) : '#';
        $stars      = intval( $s['star_rating'] ?? 5 );
        ?>
        <section class="ps-hero">
            <div class="ps-hero__inner">

                <!-- Text column -->
                <div class="ps-hero__content">

                    <?php if ( ! empty( $s['badge_text'] ) ) : ?>
                    <span class="ps-hero__badge">
                        <?php echo esc_html( $s['badge_text'] ); ?>
                    </span>
                    <?php endif; ?>

                    <h1 class="ps-hero__heading">
                        <?php echo nl2br( esc_html( $s['heading'] ) ); ?>
                    </h1>

                    <?php if ( ! empty( $s['subheading'] ) ) : ?>
                    <p class="ps-hero__sub">
                        <?php echo esc_html( $s['subheading'] ); ?>
                    </p>
                    <?php endif; ?>

                    <div class="ps-hero__actions">
                        <a href="<?php echo $primary_url; ?>"
                           class="ps-hero__cta ps-hero__cta--primary"
                           <?php echo ( $s['cta_primary_url']['is_external'] ?? '' ) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
                            <?php echo esc_html( $s['cta_primary_text'] ); ?>
                        </a>

                        <?php if ( ! empty( $s['cta_secondary_text'] ) ) : ?>
                        <span class="ps-hero__avail">
                            <span class="ps-hero__avail-dot" aria-hidden="true"></span>
                            <?php echo esc_html( $s['availability_text'] ); ?>
                        </span>
                        <?php endif; ?>
                    </div>

                    <?php if ( ! empty( $s['social_proof_avatars'] ) ) : ?>
                    <div class="ps-hero__proof">
                        <div class="ps-hero__proof-avatars" aria-hidden="true">
                            <?php foreach ( $s['social_proof_avatars'] as $item ) : ?>
                                <?php if ( ! empty( $item['avatar']['url'] ) ) : ?>
                                <img src="<?php echo esc_url( $item['avatar']['url'] ); ?>"
                                     alt="<?php echo esc_attr( $item['name'] ); ?>"
                                     width="36" height="36"
                                     loading="lazy">
                                <?php else : ?>
                                <span class="ps-hero__proof-placeholder" aria-hidden="true">
                                    <?php echo esc_html( mb_substr( $item['name'], 0, 1 ) ); ?>
                                </span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <div class="ps-hero__proof-text">
                            <span class="ps-hero__stars" aria-label="<?php echo esc_attr( $stars . ' stars' ); ?>">
                                <?php echo str_repeat( '★', $stars ) . str_repeat( '☆', 5 - $stars ); ?>
                            </span>
                            <span><?php echo esc_html( $s['social_proof_text'] ); ?></span>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Image column -->
                <?php if ( ! empty( $s['avatar_image']['url'] ) ) : ?>
                <div class="ps-hero__visual">
                    <div class="ps-hero__avatar-wrap">
                        <img src="<?php echo esc_url( $s['avatar_image']['url'] ); ?>"
                             alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"
                             class="ps-hero__avatar"
                             loading="eager"
                             width="560" height="640">
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </section>

        <style>
        .ps-hero {
            min-height: 100svh;
            display: flex;
            align-items: center;
            padding: clamp(3rem, 8vw, 6rem) clamp(1.25rem, 5vw, 4rem);
            position: relative;
            overflow: hidden;
        }
        .ps-hero__inner {
            max-width: 1240px;
            margin: 0 auto;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: clamp(2rem, 6vw, 5rem);
            align-items: center;
        }
        .ps-hero__badge {
            display: inline-block;
            border: 1px solid currentColor;
            border-radius: 9999px;
            padding: 0.3em 0.9em;
            font-size: 0.8rem;
            font-weight: 500;
            letter-spacing: 0.02em;
            margin-bottom: 1.5rem;
            opacity: 0.9;
        }
        .ps-hero__heading {
            font-size: clamp(2rem, 5.5vw, 3.75rem);
            font-weight: 800;
            line-height: 1.08;
            letter-spacing: -0.02em;
            margin-bottom: 1.25rem;
        }
        .ps-hero__sub {
            font-size: clamp(0.95rem, 2vw, 1.1rem);
            line-height: 1.7;
            opacity: 0.7;
            max-width: 48ch;
            margin-bottom: 2rem;
        }
        .ps-hero__actions {
            display: flex;
            align-items: center;
            gap: 1.25rem;
            flex-wrap: wrap;
            margin-bottom: 2.5rem;
        }
        .ps-hero__cta {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            border-radius: 9999px;
            padding: 0.75em 1.75em;
            font-weight: 600;
            font-size: 0.95rem;
            transition: filter var(--transition-base), transform var(--transition-fast);
        }
        .ps-hero__cta:hover  { filter: brightness(1.12); transform: translateY(-1px); }
        .ps-hero__cta:active { transform: translateY(0); }
        .ps-hero__cta--primary { color: #fff; }
        .ps-hero__avail {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.85rem;
            opacity: 0.75;
        }
        .ps-hero__avail-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
            animation: pulse-dot 2s ease-in-out infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50%       { opacity: 0.6; transform: scale(0.85); }
        }
        @media (prefers-reduced-motion: reduce) {
            .ps-hero__avail-dot { animation: none; }
        }

        /* Social proof */
        .ps-hero__proof {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .ps-hero__proof-avatars {
            display: flex;
        }
        .ps-hero__proof-avatars img,
        .ps-hero__proof-placeholder {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: 2px solid var(--surface);
            object-fit: cover;
            margin-left: -10px;
        }
        .ps-hero__proof-avatars img:first-child,
        .ps-hero__proof-placeholder:first-child { margin-left: 0; }
        .ps-hero__proof-placeholder {
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--color-base-700);
            font-size: 0.75rem;
            font-weight: 700;
        }
        .ps-hero__proof-text {
            display: flex;
            flex-direction: column;
            gap: 0.1rem;
            font-size: 0.8rem;
            opacity: 0.8;
        }
        .ps-hero__stars { font-size: 0.85rem; letter-spacing: 0.05em; }

        /* Avatar visual */
        .ps-hero__visual {
            display: flex;
            justify-content: center;
        }
        .ps-hero__avatar-wrap {
            border-radius: var(--radius-xl);
            overflow: hidden;
            max-width: 480px;
            width: 100%;
            transition: box-shadow var(--transition-base);
        }
        .ps-hero__avatar {
            width: 100%;
            height: auto;
            display: block;
            border-radius: var(--radius-xl);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .ps-hero__inner {
                grid-template-columns: 1fr;
            }
            .ps-hero__visual {
                order: -1;
                max-width: 320px;
                margin: 0 auto;
            }
        }
        </style>
        <?php
    }
}
