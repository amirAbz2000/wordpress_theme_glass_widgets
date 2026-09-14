<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class Personal_Site_Glass_Card_Grid_Widget extends \Elementor\Widget_Base {

    public function get_name(): string       { return 'personal_site_glass_card_grid'; }
    public function get_title(): string      { return esc_html__( 'Glass Card Grid', 'personal-site' ); }
    public function get_icon(): string       { return 'eicon-gallery-grid'; }
    public function get_categories(): array  { return [ 'personal-site' ]; }
    public function get_keywords(): array    { return [ 'cards', 'services', 'features', 'glass', 'grid' ]; }

    protected function register_controls(): void {

        $this->start_controls_section( 'section_cards', [
            'label' => esc_html__( 'Cards', 'personal-site' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'section_title', [
            'label'   => esc_html__( 'Section Title', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__( 'My Services', 'personal-site' ),
        ] );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control( 'icon', [
            'label'   => esc_html__( 'Icon', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::ICONS,
            'default' => [
                'value'   => 'fas fa-paint-brush',
                'library' => 'fa-solid',
            ],
        ] );

        $repeater->add_control( 'title', [
            'label'   => esc_html__( 'Card Title', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => esc_html__( 'UI/UX Design', 'personal-site' ),
        ] );

        $repeater->add_control( 'description', [
            'label'   => esc_html__( 'Description', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => esc_html__( 'Crafting intuitive, beautiful interfaces that users love.', 'personal-site' ),
            'rows'    => 3,
        ] );

        $repeater->add_control( 'link', [
            'label' => esc_html__( 'Card Link', 'personal-site' ),
            'type'  => \Elementor\Controls_Manager::URL,
        ] );

        $this->add_control( 'cards', [
            'label'       => esc_html__( 'Cards', 'personal-site' ),
            'type'        => \Elementor\Controls_Manager::REPEATER,
            'fields'      => $repeater->get_controls(),
            'default'     => [
                [ 'title' => 'UI/UX Design',    'description' => 'Crafting intuitive interfaces users love.' ],
                [ 'title' => 'Web Development', 'description' => 'Clean, performant, accessible code.' ],
                [ 'title' => 'Brand Identity',  'description' => 'Logos and visual systems that stick.' ],
                [ 'title' => 'Motion Design',   'description' => 'Purposeful animation that guides users.' ],
            ],
            'title_field' => '{{{ title }}}',
        ] );

        $this->add_control( 'columns', [
            'label'   => esc_html__( 'Columns', 'personal-site' ),
            'type'    => \Elementor\Controls_Manager::SELECT,
            'options' => [ '2' => '2', '3' => '3', '4' => '4' ],
            'default' => '3',
            'selectors' => [
                '{{WRAPPER}} .ps-card-grid' =>
                    'grid-template-columns: repeat({{VALUE}}, 1fr);',
            ],
        ] );

        $this->end_controls_section();

        // Style
        $this->start_controls_section( 'section_style', [
            'label' => esc_html__( 'Style', 'personal-site' ),
            'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
        ] );

        $this->add_control( 'icon_color', [
            'label'     => esc_html__( 'Icon Color', 'personal-site' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'oklch(65% 0.20 52)',
            'selectors' => [
                '{{WRAPPER}} .ps-card__icon' => 'color: {{VALUE}};',
            ],
        ] );

        $this->add_control( 'card_hover_border_color', [
            'label'     => esc_html__( 'Card Hover Border', 'personal-site' ),
            'type'      => \Elementor\Controls_Manager::COLOR,
            'default'   => 'oklch(65% 0.20 52 / 0.4)',
            'selectors' => [
                '{{WRAPPER}} .ps-card:hover' => 'border-color: {{VALUE}};',
            ],
        ] );

        $this->end_controls_section();
    }

    protected function render(): void {
        $s = $this->get_settings_for_display();
        ?>
        <section class="ps-cards-section">

            <?php if ( ! empty( $s['section_title'] ) ) : ?>
            <h2 class="ps-cards-section__title">
                <?php echo esc_html( $s['section_title'] ); ?>
            </h2>
            <?php endif; ?>

            <div class="ps-card-grid">
                <?php foreach ( $s['cards'] as $card ) :
                    $has_link = ! empty( $card['link']['url'] );
                    $tag      = $has_link ? 'a' : 'div';
                    $attrs    = '';
                    if ( $has_link ) {
                        $attrs .= ' href="' . esc_url( $card['link']['url'] ) . '"';
                        if ( ! empty( $card['link']['is_external'] ) ) {
                            $attrs .= ' target="_blank" rel="noopener noreferrer"';
                        }
                    }
                    ?>
                    <<?php echo esc_attr( $tag ); ?> class="ps-card glass"<?php echo $attrs; ?>>

                        <?php if ( ! empty( $card['icon']['value'] ) ) : ?>
                        <span class="ps-card__icon" aria-hidden="true">
                            <?php \Elementor\Icons_Manager::render_icon( $card['icon'], [ 'aria-hidden' => 'true' ] ); ?>
                        </span>
                        <?php endif; ?>

                        <h3 class="ps-card__title">
                            <?php echo esc_html( $card['title'] ); ?>
                        </h3>

                        <?php if ( ! empty( $card['description'] ) ) : ?>
                        <p class="ps-card__desc">
                            <?php echo esc_html( $card['description'] ); ?>
                        </p>
                        <?php endif; ?>

                        <?php if ( $has_link ) : ?>
                        <span class="ps-card__arrow" aria-hidden="true">→</span>
                        <?php endif; ?>

                    </<?php echo esc_attr( $tag ); ?>>
                <?php endforeach; ?>
            </div>
        </section>

        <style>
        .ps-cards-section { padding: clamp(3rem, 8vw, 5rem) 0; }
        .ps-cards-section__title {
            font-size: clamp(1.6rem, 4vw, 2.5rem);
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 2.5rem;
        }
        .ps-card-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.25rem;
        }
        .ps-card {
            padding: 2rem 1.75rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            transition: transform var(--transition-base), border-color var(--transition-base);
            text-decoration: none;
            color: inherit;
        }
        .ps-card:hover { transform: translateY(-6px); }
        .ps-card__icon {
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            width: 48px;
            height: 48px;
            border-radius: var(--radius-md);
            background: oklch(100% 0 0 / 0.06);
            justify-content: center;
        }
        .ps-card__title {
            font-size: 1.05rem;
            font-weight: 700;
            line-height: 1.3;
        }
        .ps-card__desc {
            font-size: 0.88rem;
            opacity: 0.65;
            line-height: 1.65;
            flex: 1;
        }
        .ps-card__arrow {
            font-size: 1rem;
            opacity: 0.4;
            transition: opacity var(--transition-fast), transform var(--transition-fast);
            display: inline-block;
        }
        .ps-card:hover .ps-card__arrow { opacity: 1; transform: translateX(4px); }

        @media (max-width: 900px) {
            .ps-card-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 560px) {
            .ps-card-grid { grid-template-columns: 1fr; }
        }
        </style>
        <?php
    }
}
