<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Personal_Site_About_Widget extends \Elementor\Widget_Base {

    public function get_name(): string       { return 'personal_site_about'; }
    public function get_title(): string      { return esc_html__( 'About Section', 'personal-site' ); }
    public function get_icon(): string       { return 'eicon-person'; }
    public function get_categories(): array  { return [ 'personal-site' ]; }
    public function get_keywords(): array    { return [ 'about', 'bio', 'profile', 'skills' ]; }

    protected function register_controls(): void {

        $this->start_controls_section( 'section_about', [
            'label' => esc_html__( 'About', 'personal-site' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => esc_html__( 'Eyebrow Label', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__( 'About me', 'personal-site' ),
        ] );

        $this->add_control( 'heading', [
            'label'   => esc_html__( 'Heading', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => esc_html__( "I'm Floyd Miles,\nYour Creative Partner In Design", 'personal-site' ),
            'rows'    => 3,
        ] );

        $this->add_control( 'bio', [
            'label'   => esc_html__( 'Bio Text', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::WYSIWYG,
            'default' => esc_html__( 'For me, design is all about creating experiences that really connect with people. It\'s not just about looking good — it\'s about engaging and inspiring.', 'personal-site' ),
        ] );

        $this->add_control( 'photo', [
            'label'   => esc_html__( 'Photo', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
        ] );

        $this->end_controls_section();

        // Skills
        $this->start_controls_section( 'section_skills', [
            'label' => esc_html__( 'Skills / Tags', 'personal-site' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $repeater = new \Elementor\Repeater();
        $repeater->add_control( 'skill', [
            'label'   => esc_html__( 'Skill', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'UI/UX Design',
        ] );

        $this->add_control( 'skills', [
            'label'       => esc_html__( 'Skills', 'personal-site' ),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [ 'skill' => 'UI/UX Design' ],
                [ 'skill' => 'Web Development' ],
                [ 'skill' => 'Brand Identity' ],
                [ 'skill' => 'Motion Design' ],
                [ 'skill' => 'Creative Direction' ],
            ],
            'title_field' => '{{{ skill }}}',
        ] );

        $this->end_controls_section();

        // CTA
        $this->start_controls_section( 'section_cta', [
            'label' => esc_html__( 'Call to Action', 'personal-site' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'cta_text', [
            'label'   => esc_html__( 'Button Text', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__( 'Download CV', 'personal-site' ),
        ] );

        $this->add_control( 'cta_url', [
            'label' => esc_html__( 'Button URL', 'personal-site' ),
            'type'  => \Elementor\Controls_Manager::URL,
        ] );

        $this->end_controls_section();

        // Style
        $this->start_controls_section( 'section_style', [
            'label' => esc_html__( 'Style', 'personal-site' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'accent_color', [
            'label'     => esc_html__( 'Accent Color', 'personal-site' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'oklch(65% 0.20 52)',
            'selectors' => [
                '{{WRAPPER}} .ps-about__eyebrow'   => 'color: {{VALUE}};',
                '{{WRAPPER}} .ps-about__cta'        => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .ps-about__skill-tag'  => 'border-color: {{VALUE}}33; color: {{VALUE}};',
                '{{WRAPPER}} .ps-about__photo-glow' => 'background: radial-gradient(circle, {{VALUE}}44 0%, transparent 70%);',
            ],
        ] );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'     => 'heading_typography',
                'selector' => '{{WRAPPER}} .ps-about__heading',
            ]
        );

        $this->end_controls_section();
    }

    protected function render(): void {
        $s       = $this->get_settings_for_display();
        $cta_url = ! empty( $s['cta_url']['url'] ) ? esc_url( $s['cta_url']['url'] ) : '#';
        ?>
        <section class="ps-about">
            <!-- Image column -->
            <div class="ps-about__visual">
                <div class="ps-about__photo-glow" aria-hidden="true"></div>
                <?php if ( ! empty( $s['photo']['url'] ) ) : ?>
                <div class="ps-about__photo-frame glass">
                    <img src="<?php echo esc_url( $s['photo']['url'] ); ?>"
                         alt="<?php esc_attr_e( 'Profile photo', 'personal-site' ); ?>"
                         class="ps-about__photo"
                         loading="lazy">
                </div>
                <?php endif; ?>
            </div>

            <!-- Text column -->
            <div class="ps-about__content">
                <?php if ( ! empty( $s['eyebrow'] ) ) : ?>
                <span class="ps-about__eyebrow">
                    <?php echo esc_html( $s['eyebrow'] ); ?>
                </span>
                <?php endif; ?>

                <h2 class="ps-about__heading">
                    <?php echo nl2br( esc_html( $s['heading'] ) ); ?>
                </h2>

                <?php if ( ! empty( $s['bio'] ) ) : ?>
                <div class="ps-about__bio">
                    <?php echo wp_kses_post( $s['bio'] ); ?>
                </div>
                <?php endif; ?>

                <?php if ( ! empty( $s['skills'] ) ) : ?>
                <div class="ps-about__skills" aria-label="<?php esc_attr_e( 'Skills', 'personal-site' ); ?>">
                    <?php foreach ( $s['skills'] as $item ) : ?>
                    <span class="ps-about__skill-tag">
                        <?php echo esc_html( $item['skill'] ); ?>
                    </span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <?php if ( ! empty( $s['cta_text'] ) ) : ?>
                <a href="<?php echo $cta_url; ?>"
                   class="ps-about__cta"
                   <?php echo ( $s['cta_url']['is_external'] ?? '' ) ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>>
                    <?php echo esc_html( $s['cta_text'] ); ?>
                </a>
                <?php endif; ?>
            </div>
        </section>

        <style>
        .ps-about {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: clamp(2rem, 6vw, 5rem);
            align-items: center;
            padding: clamp(3rem, 8vw, 5rem) 0;
        }
        .ps-about__visual {
            position: relative;
            display: flex;
            justify-content: center;
        }
        .ps-about__photo-glow {
            position: absolute;
            inset: -20%;
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }
        .ps-about__photo-frame {
            position: relative;
            z-index: 1;
            overflow: hidden;
            max-width: 420px;
            width: 100%;
            padding: 6px;
        }
        .ps-about__photo {
            width: 100%;
            height: auto;
            border-radius: calc(var(--radius-xl) - 6px);
            display: block;
        }

        /* Text */
        .ps-about__eyebrow {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 0.75rem;
        }
        .ps-about__heading {
            font-size: clamp(1.6rem, 4vw, 2.75rem);
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -0.02em;
            margin-bottom: 1.25rem;
        }
        .ps-about__bio {
            font-size: 0.95rem;
            line-height: 1.75;
            opacity: 0.75;
            margin-bottom: 1.5rem;
            max-width: 52ch;
        }
        .ps-about__skills {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 2rem;
        }
        .ps-about__skill-tag {
            border: 1px solid;
            border-radius: var(--radius-pill);
            padding: 0.3em 0.9em;
            font-size: 0.8rem;
            font-weight: 500;
            background: transparent;
        }
        .ps-about__cta {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75em 2em;
            border-radius: var(--radius-pill);
            font-weight: 600;
            font-size: 0.95rem;
            color: #fff;
            transition: filter var(--transition-base), transform var(--transition-fast);
        }
        .ps-about__cta:hover  { filter: brightness(1.12); transform: translateY(-1px); }
        .ps-about__cta:active { transform: translateY(0); }

        @media (max-width: 768px) {
            .ps-about { grid-template-columns: 1fr; }
            .ps-about__visual { max-width: 340px; margin: 0 auto; }
        }
        </style>
        <?php
    }
}
