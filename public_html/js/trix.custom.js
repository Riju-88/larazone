let trixEditor;

document.addEventListener('trix-initialize', function () {
  trixEditor = document.querySelector('trix-editor');
  if (trixEditor) {
    addCustomButtons();
  } else {
    console.error('Trix editor not found.');
  }
});

document.addEventListener('trix-file-accept', function () {
  addCustomButtons();
});

function addCustomButtons() {
  addForegroundButtonConfig();
  addBackgroundButtonConfig();
  addTextAlignCenterButtonConfig();
  addSpoilerButtonConfig();
}
function addSpoilerButtonConfig() {
    Trix.config.textAttributes.spoiler = {
        tagName: 'spoiler',
        
        className: 'spoiler',
        style: { 'background-color': 'black', color: 'black' },
        inheritable: true,
       
    };

    // Add the spoiler button to the toolbar
    trixEditor.toolbarElement.innerHTML = getDefaultHTML();
}

// function addSpoilerButtonConfig() {
//     Trix.config.textAttributes.spoiler = {
//         tagName: 'span',
//         style: { 'background-color': 'black', color: 'black' },
//         inheritable: true,
//         parser: function (element) {
//             return element.tagName.toLowerCase() === 'span' && element.style.backgroundColor === 'black' && element.style.color === 'black';
//         },
//         selector: function (element) {
//             return element.tagName.toLowerCase() === 'span' && element.style.backgroundColor === 'black' && element.style.color === 'black';
//         }
//     };

//     trixEditor.toolbarElement.querySelector('.trix-button--icon-spoiler').addEventListener('click', function () {
//         toggleSpoiler();
//     });
// }

function openColorPicker(pickerId) {
  document.getElementById(pickerId).click();
}

function colorChanged(attribute, pickerId) {
  if (trixEditor) {
    trixEditor.editor.activateAttribute(attribute, document.getElementById(pickerId).value);
  } else {
    console.error('Trix editor not initialized.');
  }
}

function addForegroundButtonConfig() {
  Trix.config.textAttributes.foregroundColor = {
    styleProperty: 'color',
    inheritable: true
  };
}

function addBackgroundButtonConfig() {
  Trix.config.textAttributes.backgroundColor = {
    styleProperty: 'backgroundColor',
    inheritable: true
  };
}



function addTextAlignCenterButtonConfig() {
  Trix.config.blockAttributes.textAlignCenter = {
    tagName: 'centered-div'
  };

  // Set the toolbar HTML after adding the custom configurations
  trixEditor.toolbarElement.innerHTML = getDefaultHTML();
}

function getDefaultHTML() {
            return `<div class="trix-button-row">
                   <span class="trix-button-group                               trix-button-group--text-tools"                                data-trix-button-group="text-tools">
                    <button type="button" class="trix-button trix-button--icon trix-button--icon-bold" data-trix-attribute="bold" data-trix-key="b" title="Bold" tabindex="-1">Bold</button>
                    <button type="button" class="trix-button trix-button--icon trix-button--icon-italic" data-trix-attribute="italic" data-trix-key="i" title="Italic" tabindex="-1">Italic</button>
                    ${getSpoilerButton()}
                    <button type="button" class="trix-button trix-button--icon trix-button--icon-strike" data-trix-attribute="strike" title="Strike" tabindex="-1">Strike</button>
                    <button type="button" class="trix-button trix-button--icon trix-button--icon-link" data-trix-attribute="href" data-trix-action="link" data-trix-key="k" title="Link" tabindex="-1">Link</button>
                    
                    ${getColorPickerButtons('foregroundColor', 'foregroundColorPicker', 'format_color_text')}
                    ${getColorPickerButtons('backgroundColor', 'backgroundColorPicker', 'format_color_fill')}
                    
    </span>

    <span class="trix-button-group trix-button-group--block-tools" data-trix-button-group="block-tools">
      <button type="button" class="trix-button trix-button--icon trix-button--icon-heading-1" data-trix-attribute="heading1" title="Heading 1" tabindex="-1">Heading 1</button>
      <button type="button" class="trix-button trix-button--icon trix-button--icon-quote" data-trix-attribute="quote" title="Quote" tabindex="-1">Quote</button>
      <button type="button" class="trix-button trix-button--icon trix-button--icon-code" data-trix-attribute="code" title="Code" tabindex="-1">Code</button>
      <button type="button" class="trix-button trix-button--icon trix-button--icon-bullet-list" data-trix-attribute="bullet" title="Bullets" tabindex="-1">Bullets</button>
      <button type="button" class="trix-button trix-button--icon trix-button--icon-number-list" data-trix-attribute="number" title="Numbers" tabindex="-1">Numbers</button>
      <button type="button" class="trix-button trix-button--icon trix-button--icon-decrease-nesting-level" data-trix-action="decreaseNestingLevel" title="Outdent" tabindex="-1">Outdent</button>
      <button type="button" class="trix-button trix-button--icon trix-button--icon-increase-nesting-level" data-trix-action="increaseNestingLevel" title="Indent" tabindex="-1">Indent</button>
      
    </span>
    <span class="trix-button-group trix-button-group--file-tools" data-trix-button-group="file-tools">
      <button type="button" class="trix-button trix-button--icon trix-button--icon-attach" data-trix-action="attachFiles" title="Attach Files" tabindex="-1">Attach Files</button>
    </span>
    <span class="trix-button-group-spacer"></span>
    <span class="trix-button-group trix-button-group--history-tools" data-trix-button-group="history-tools">
      <button type="button" class="trix-button trix-button--icon trix-button--icon-undo" data-trix-action="undo" data-trix-key="z" title="Undo" tabindex="-1">Undo</button>
      <button type="button" class="trix-button trix-button--icon trix-button--icon-redo" data-trix-action="redo" data-trix-key="shift+z" title="Redo" tabindex="-1">Redo</button>
    </span>
  </div>
  <div class="trix-dialogs" data-trix-dialogs="">
  <div class="trix-dialog trix-dialog--link" data-trix-dialog="href" data-trix-dialog-attribute="href">
    <div class="trix-dialog__link-fields">
      <input type="url" name="href" class="trix-input trix-input--dialog" placeholder="Enter a URL…" aria-label="URL" required="" data-trix-input="" disabled="disabled">
      <div class="trix-button-group">
        <input type="button" class="trix-button trix-button--dialog" value="Link" data-trix-method="setAttribute">
        <input type="button" class="trix-button trix-button--dialog" value="Unlink" data-trix-method="removeAttribute">
      </div>
    </div>
  </div>
</div>`;
        }

        function getColorPickerButtons(attribute, pickerId, iconName) {
            const title = attribute === 'backgroundColor' ? 'Background' : 'Foreground';

          
            return `<input type="color" style="width:0;height:0;padding:0;margin-top:20px;visibility:hidden"
                           id="${pickerId}" onchange="colorChanged('${attribute}', '${pickerId}')">
                    <button type="button" class="trix-button" onclick="openColorPicker('${pickerId}')" title="${title} color">
                    <span class="material-symbols-outlined">${iconName}</span>
                    </button>`;
          }
          
        
          function getSpoilerButton() {
            return `<button type="button" class="trix-button" onclick="toggleSpoiler()" title="Spoiler" tabindex="-1">
            <span class="material-symbols-outlined">
            preview
            </span>
            </button>`;
        }
        function toggleSpoiler() {
            if (trixEditor) {
                trixEditor.editor.activateAttribute('spoiler', true);
            } else {
                console.error('Trix editor not initialized.');
            }
        }
        
    
      
        
        
     