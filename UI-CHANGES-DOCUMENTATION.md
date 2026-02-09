# UI Changes Documentation

## Admin Panel Changes

### 1. Feature Cards - Create/Edit Form

#### New Section: Color Preset Selector

**Location**: Between "Ícone (Emoji)" field and color customization grid

```
┌─────────────────────────────────────────────────────────────┐
│ Paleta de Cores                                              │
├─────────────────────────────────────────────────────────────┤
│                                                               │
│ Escolha um modelo pronto:                                    │
│ ┌────────────────────────────────────────────────────────┐  │
│ │ -- Selecione um modelo --                          ▼  │  │
│ │ Primary (Azul)                                         │  │
│ │ Dourado                                                │  │
│ │ Neutro (Cinza)                                         │  │
│ │ Azul Claro                                             │  │
│ │ Verde                                                  │  │
│ └────────────────────────────────────────────────────────┘  │
│                                                               │
│ Ou personalize as cores manualmente abaixo                   │
└─────────────────────────────────────────────────────────────┘
```

**Behavior**: 
- When a preset is selected, the color fields below are automatically filled
- User can still modify individual colors after preset selection
- JavaScript handles the field population instantly

#### New Section: Position Selection

**Location**: After "Ordem" field

```
┌─────────────────────────────────────────────────────────────┐
│ Posição de Exibição                                          │
│ ┌────────────────────────────────────────────────────────┐  │
│ │ Exibir na posição padrão (seção de recursos)       ▼  │  │
│ │ Acima do Slider                                        │  │
│ │ Abaixo do Slider                                       │  │
│ │ Acima dos Cards de Recursos                            │  │
│ │ Abaixo dos Cards de Recursos                           │  │
│ │ Acima dos Eventos                                      │  │
│ │ Abaixo dos Eventos                                     │  │
│ │ Acima dos Artigos                                      │  │
│ │ Abaixo dos Artigos                                     │  │
│ │ Acima da Chamada para Ação                             │  │
│ │ Abaixo da Chamada para Ação                            │  │
│ └────────────────────────────────────────────────────────┘  │
│ Escolha onde este card será exibido na página inicial        │
│                                                               │
│ Ordem na Posição                                             │
│ ┌────────┐                                                   │
│ │   0    │                                                   │
│ └────────┘                                                   │
│ Ordem de exibição na posição selecionada                     │
└─────────────────────────────────────────────────────────────┘
```

---

### 2. Homepage Sections - Create/Edit Form

#### New Section: Position Selection

**Location**: After "Subtítulo" field

```
┌─────────────────────────────────────────────────────────────┐
│ Posição de Exibição                                          │
│ ┌────────────────────────────────────────────────────────┐  │
│ │ Não exibir na página inicial                       ▼  │  │
│ │ Acima do Slider                                        │  │
│ │ Abaixo do Slider                                       │  │
│ │ Acima dos Cards de Recursos                            │  │
│ │ Abaixo dos Cards de Recursos                           │  │
│ │ Acima dos Eventos                                      │  │
│ │ Abaixo dos Eventos                                     │  │
│ │ Acima dos Artigos                                      │  │
│ │ Abaixo dos Artigos                                     │  │
│ │ Acima da Chamada para Ação                             │  │
│ │ Abaixo da Chamada para Ação                            │  │
│ └────────────────────────────────────────────────────────┘  │
│ Escolha onde esta seção será exibida na página inicial       │
│                                                               │
│ Ordem de Exibição                                            │
│ ┌────────┐                                                   │
│ │   0    │                                                   │
│ └────────┘                                                   │
│ Ordem de exibição na posição selecionada (menor aparece      │
│ primeiro)                                                     │
└─────────────────────────────────────────────────────────────┘
```

---

## Homepage Display Changes

### Dynamic Content Rendering

The homepage now supports 10 insertion points for custom sections and feature cards:

```
┌───────────────────────────────────────────────────────────┐
│                      Navigation                            │
└───────────────────────────────────────────────────────────┘

    ↓ [Above Slider] - Custom sections/cards can appear here

┌───────────────────────────────────────────────────────────┐
│                     Hero Slider                            │
│                   (if sliders exist)                       │
└───────────────────────────────────────────────────────────┘

    ↓ [Below Slider] - Custom sections/cards can appear here
    ↓ [Above Features] - Custom sections/cards can appear here

┌───────────────────────────────────────────────────────────┐
│                   Features Section                         │
│        (Default location for feature cards)                │
│  ┌─────────┐  ┌─────────┐  ┌─────────┐                   │
│  │  Card 1  │  │  Card 2  │  │  Card 3  │                 │
│  └─────────┘  └─────────┘  └─────────┘                   │
└───────────────────────────────────────────────────────────┘

    ↓ [Below Features] - Custom sections/cards can appear here
    ↓ [Above Events] - Custom sections/cards can appear here

┌───────────────────────────────────────────────────────────┐
│                    Events Section                          │
│              (if events exist)                             │
└───────────────────────────────────────────────────────────┘

    ↓ [Below Events] - Custom sections/cards can appear here
    ↓ [Above Articles] - Custom sections/cards can appear here

┌───────────────────────────────────────────────────────────┐
│                  Articles Section                          │
│              (if articles exist)                           │
└───────────────────────────────────────────────────────────┘

    ↓ [Below Articles] - Custom sections/cards can appear here
    ↓ [Above CTA] - Custom sections/cards can appear here

┌───────────────────────────────────────────────────────────┐
│                  Call to Action                            │
│               (Junte-se a Nós)                             │
└───────────────────────────────────────────────────────────┘

    ↓ [Below CTA] - Custom sections/cards can appear here

┌───────────────────────────────────────────────────────────┐
│                       Footer                               │
└───────────────────────────────────────────────────────────┘
```

### Custom Section Rendering

When a homepage section is placed at a custom position:

```
┌───────────────────────────────────────────────────────────┐
│                                                             │
│              Custom Section Title                           │
│                                                             │
│                  Section Subtitle                           │
│                                                             │
└───────────────────────────────────────────────────────────┘
```

**Styling**: 
- Gradient background (primary-50 to white)
- Large centered title
- Subtitle in smaller text
- Full-width responsive container

### Custom Feature Card Rendering

When a feature card is placed at a custom position:

```
┌───────────────────────────────────────────────────────────┐
│                   ┌─────────────────┐                      │
│                   │       🙏        │                      │
│                   │                 │                      │
│                   │   Card Title    │                      │
│                   │                 │                      │
│                   │  Description    │                      │
│                   │     text...     │                      │
│                   │                 │                      │
│                   └─────────────────┘                      │
└───────────────────────────────────────────────────────────┘
```

**Styling**:
- Centered single card layout
- Gradient background based on selected colors
- Large emoji icon at top
- Bold colored title
- Description text below
- Rounded corners with shadow

---

## Color Presets Visual Reference

### 1. Primary (Azul)
```
┌──────────────────────────────────────┐
│ Gradient: primary-50 → white         │
│ Border: primary-100                  │
│ Text: primary-800                    │
│                                      │
│ Colors: Light blue to white          │
└──────────────────────────────────────┘
```

### 2. Dourado (Gold)
```
┌──────────────────────────────────────┐
│ Gradient: gold-50 → white            │
│ Border: gold-100                     │
│ Text: gold-800                       │
│                                      │
│ Colors: Light gold to white          │
└──────────────────────────────────────┘
```

### 3. Neutro (Cinza)
```
┌──────────────────────────────────────┐
│ Gradient: neutral-50 → white         │
│ Border: neutral-200                  │
│ Text: neutral-900                    │
│                                      │
│ Colors: Light gray to white          │
└──────────────────────────────────────┘
```

### 4. Azul Claro (Light Blue)
```
┌──────────────────────────────────────┐
│ Gradient: blue-50 → white            │
│ Border: blue-100                     │
│ Text: blue-800                       │
│                                      │
│ Colors: Sky blue to white            │
└──────────────────────────────────────┘
```

### 5. Verde (Green)
```
┌──────────────────────────────────────┐
│ Gradient: green-50 → white           │
│ Border: green-100                    │
│ Text: green-800                      │
│                                      │
│ Colors: Light green to white         │
└──────────────────────────────────────┘
```

---

## User Experience Flow

### Creating a Feature Card with Color Preset:

1. Admin navigates to `/admin/feature-cards/create`
2. Fills in title: "Comunidade"
3. Fills in description: "Somos uma família unida pela fé"
4. Sets icon: "👨‍👩‍👧‍👦"
5. **Selects preset**: Clicks dropdown "Paleta de Cores" → selects "Verde"
6. **Auto-filled**: All color fields are automatically populated
7. Optional: Adjusts "Cor da Borda" to customize
8. Sets order: 3
9. **Selects position**: Chooses "Abaixo dos Eventos"
10. Sets display order: 1
11. Clicks "Criar Card"

**Result**: Card appears below the events section on homepage with green color scheme

### Creating a Homepage Section with Position:

1. Admin navigates to `/admin/homepage-sections/create`
2. Fills in key: "welcome_message"
3. Fills in title: "Bem-vindo ao Apostolado"
4. Fills in subtitle: "Juntos em oração e missão"
5. **Selects position**: Chooses "Acima do Slider"
6. Sets display order: 0
7. Checks "Seção ativa"
8. Clicks "Criar Seção"

**Result**: Section appears at the very top of homepage, above the hero slider

---

## Mobile Responsiveness

All new UI elements are fully responsive:

- **Desktop**: Full-width forms with proper spacing
- **Tablet**: Adjusted spacing, readable dropdowns
- **Mobile**: Stacked layout, touch-friendly dropdowns

Dynamic content on homepage adapts:
- Custom sections: Full-width on mobile, centered on desktop
- Custom cards: Single column on mobile, centered display
- Proper padding and margins for all screen sizes

---

## Backward Compatibility

### Existing Cards and Sections:

- Feature cards without `display_position` → Still appear in default feature section
- Homepage sections without `display_position` → Not displayed on homepage (as before)
- All existing color configurations → Work exactly as before
- No breaking changes to existing functionality

---

## Technical Notes

### JavaScript Enhancement:

The color preset selector uses vanilla JavaScript (no dependencies):

```javascript
document.getElementById('color_preset').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    if (selectedOption.value) {
        document.getElementById('color_from').value = selectedOption.dataset.from;
        document.getElementById('color_to').value = selectedOption.dataset.to;
        document.getElementById('border_color').value = selectedOption.dataset.border;
        document.getElementById('text_color').value = selectedOption.dataset.text;
    }
});
```

**Benefits**:
- No page reload required
- Instant feedback
- Progressive enhancement (works without JS, better with JS)

### Performance:

- Dynamic content is loaded in a single query per type (sections/cards)
- Position grouping happens in memory
- No N+1 queries
- Efficient rendering with Blade partials

---

## Accessibility

- All form fields have proper labels
- Dropdown options have descriptive text in Portuguese
- Help text provides context for each field
- Keyboard navigation fully supported
- Screen reader friendly markup

---

## Internationalization

All text is in Portuguese (pt_BR) as per application locale:
- "Paleta de Cores" (Color Palette)
- "Escolha um modelo pronto" (Choose a ready-made template)
- "Posição de Exibição" (Display Position)
- "Ordem de Exibição" (Display Order)

---

This UI design provides:
✅ Intuitive admin interface
✅ Flexible content positioning
✅ Beautiful color presets
✅ Responsive design
✅ Backward compatibility
✅ Excellent user experience
