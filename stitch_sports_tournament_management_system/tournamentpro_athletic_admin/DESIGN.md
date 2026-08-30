---
name: TournamentPro Athletic Admin
colors:
  surface: '#f7f9fb'
  surface-dim: '#d8dadc'
  surface-bright: '#f7f9fb'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f2f4f6'
  surface-container: '#eceef0'
  surface-container-high: '#e6e8ea'
  surface-container-highest: '#e0e3e5'
  on-surface: '#191c1e'
  on-surface-variant: '#4c4546'
  inverse-surface: '#2d3133'
  inverse-on-surface: '#eff1f3'
  outline: '#7e7576'
  outline-variant: '#cfc4c5'
  surface-tint: '#5e5e5e'
  primary: '#000000'
  on-primary: '#ffffff'
  primary-container: '#1b1b1b'
  on-primary-container: '#848484'
  inverse-primary: '#c6c6c6'
  secondary: '#5d5f5f'
  on-secondary: '#ffffff'
  secondary-container: '#e2e3e2'
  on-secondary-container: '#636565'
  tertiary: '#000000'
  on-tertiary: '#ffffff'
  tertiary-container: '#001453'
  on-tertiary-container: '#607cec'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#e2e2e2'
  primary-fixed-dim: '#c6c6c6'
  on-primary-fixed: '#1b1b1b'
  on-primary-fixed-variant: '#474747'
  secondary-fixed: '#e2e3e2'
  secondary-fixed-dim: '#c6c7c6'
  on-secondary-fixed: '#1a1c1c'
  on-secondary-fixed-variant: '#454747'
  tertiary-fixed: '#dde1ff'
  tertiary-fixed-dim: '#b8c4ff'
  on-tertiary-fixed: '#001453'
  on-tertiary-fixed-variant: '#173bab'
  background: '#f7f9fb'
  on-background: '#191c1e'
  surface-variant: '#e0e3e5'
  accent-blue: '#1E40AF'
  status-success-bg: rgba(34, 197, 94, 0.1)
  status-success-text: '#166534'
  status-warning-bg: rgba(249, 115, 22, 0.1)
  status-warning-text: '#9A3412'
  status-error-bg: rgba(239, 68, 68, 0.1)
  status-error-text: '#991B1B'
  live-red: '#EF4444'
typography:
  display-lg:
    fontFamily: Inter
    fontSize: 48px
    fontWeight: '700'
    lineHeight: 56px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Inter
    fontSize: 32px
    fontWeight: '700'
    lineHeight: 40px
    letterSpacing: -0.01em
  headline-lg-mobile:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '700'
    lineHeight: 32px
  headline-md:
    fontFamily: Inter
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  title-md:
    fontFamily: Inter
    fontSize: 18px
    fontWeight: '600'
    lineHeight: 24px
  body-lg:
    fontFamily: Inter
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-md:
    fontFamily: Inter
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  label-md:
    fontFamily: Inter
    fontSize: 12px
    fontWeight: '600'
    lineHeight: 16px
    letterSpacing: 0.05em
  label-xs:
    fontFamily: Inter
    fontSize: 10px
    fontWeight: '600'
    lineHeight: 12px
rounded:
  sm: 0.125rem
  DEFAULT: 0.25rem
  md: 0.375rem
  lg: 0.5rem
  xl: 0.75rem
  full: 9999px
spacing:
  base: 8px
  gutter-md: 16px
  container-margin: 24px
  sidebar-width: 260px
  sidebar-collapsed: 72px
---

## Brand & Style
The brand personality is **authoritative, athletic, and high-performance**. It targets sports administrators and league organizers who require precision and real-time monitoring. 

The design style is **Corporate Modern with an Athletic Edge**. It utilizes a systematic "Bento Grid" approach to organize dense information into digestible modules. The aesthetic is clean and professional, using a neutral foundation to allow high-contrast status indicators (live pulses, warning barks) and primary action colors to command attention. It avoids unnecessary decoration, focusing on utility and clarity while maintaining a premium, "broadcast-quality" feel.

## Colors
The palette is built on a high-contrast foundation of absolute black and crisp white, supported by a sophisticated slate-blue neutral scale for surfaces. 

- **Primary & Secondary:** Solid Black (#000000) for headers and core brand elements, with deep grays for secondary text.
- **Accent:** "Athletic Blue" (#1E40AF) is used for primary actions, links, and active navigation states.
- **Semantic Palette:** Uses low-saturation background tints with high-saturation text for status badges (Success/Green, Warning/Orange, Error/Red).
- **Backgrounds:** The main canvas uses a very light cool-gray (#F8FAFC) to distinguish the dashboard from pure white card surfaces.

## Typography
The system relies exclusively on **Inter** to project a technical, systematic, and neutral tone. 

Typography is used to create clear information hierarchies:
- **Displays & Headlines:** Heavy weights (700) and tight letter spacing are reserved for data points and section titles to ensure they feel grounded.
- **Body:** Standardized at 14px for density, using 16px only for introductory descriptions.
- **Labels:** Small caps or bolded 12px/10px settings are used for metadata, badges, and secondary "utility" information.
- **Numbers:** Large, bold font sizes are used within scorecards and analytics to make data "glanceable."

## Layout & Spacing
The system uses a **Fixed-Fluid Hybrid** layout. 
- **Desktop:** A fixed left sidebar (260px) persists, with a fluid main content area that caps at 1440px wide. 
- **Grid:** A bento-style grid is employed for the dashboard, utilizing 16px gutters between cards.
- **Rhythm:** An 8px base unit controls all padding and margins. Container-level margins are 24px on desktop, scaling down to 16px on mobile.
- **Adaptive Rules:** On mobile, the sidebar moves to a hidden drawer, and the 3-column bento grid collapses into a single vertical stack.

## Elevation & Depth
Depth is communicated through **Tonal Layering** and **Minimalist Shadows**.

- **Level 0 (Canvas):** The background is #F8FAFC.
- **Level 1 (Cards):** Pure white (#FFFFFF) surfaces with a subtle "Card Shadow" (0px 1px 3px rgba(0,0,0,0.05)) and a light outline-variant border.
- **Level 2 (Interaction):** Hover states increase shadow depth and add a 1px colored border (Accent Blue at 20% opacity) to create a tactile "lift" effect.
- **Sidebars & Headers:** Use standard material-style elevations (Shadow-MD) to appear as if floating above the primary content canvas.

## Shapes
The shape language is **geometric and structured** with subtle softening.
- **Standard Cards:** Use a 12px (xl) corner radius for a modern feel.
- **Buttons & Inputs:** Follow a sharper 4px (lg) or 2px (default) radius to maintain an athletic, professional look.
- **Status Badges & Avatars:** Utilize full rounding (pill-shaped) to distinguish them from structural layout elements.
- **Team Logos:** Always rendered in circular containers with a white border to ensure visibility against varied backgrounds.

## Components
- **Buttons:** Primary buttons are Solid Accent Blue with white text and bolded labels. Secondary buttons are ghost-style or use a subtle background tint (#F0F7FF).
- **Cards:** Bento-style cards always include a 16px internal padding and a 1px border. They should have a dedicated header area for icons/status and a footer for actions.
- **Live Monitoring:** Interactive score inputs should use a background-shaded box (#F1F5F9) with centered, oversized text. Live matches must include a "Pulse" animation on the status dot.
- **Navigation:** The sidebar uses a "pill" highlight for active states with a 4px left-border accent in Blue to clearly indicate the current location.
- **Tables:** Data tables use a striped or "border-row" approach with 12px bold headers and 14px body text for high-density readability.
- **Inputs:** Score inputs and text fields use a subtle background fill rather than heavy borders to keep the UI looking clean.