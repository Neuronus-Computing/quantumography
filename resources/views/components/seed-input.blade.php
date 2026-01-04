@props([
    'seed' => '',
    'removable' => false,
    'showButtons' => false,
])

<div>
    <div class="form-group main-login-quantum">
        <label for="seedTags">Key Seed</label>
        <div id="seedTagsContainer" class="tags-container border p-2 mb-2">
            @if (!empty($seed))
                @foreach (explode(' ', $seed) as $word)
                    <span class="tag">
                        {{ $word }}
                        @if ($removable)
                            <i class="fas fa-times remove-tag"></i>
                        @endif
                    </span>
                @endforeach
            @endif
            <input type="text" id="newSeedInput" class="form-control mt-2" placeholder="Enter seed." maxlength="16">
        </div>
       
        {{-- <small class="text-muted">Press space to add a word. Minimum 16 seed words required.</small> --}}
        @if ($showButtons)
            <div class="row mt-2">
                <div class="col-12 text-right">
                    <div class="d-flex justify-content-between main-block-div">
                        <p class="text-left text-light-grey mb-0">
                            Please write these down incase you lose your seed.
                        </p>
                        <div>
                            
                            <button type="button" class="btn" id="downloadSeed">
                                <img src="{{ asset('assets/images/quantumography/save.svg') }}" style="width: 26px;"> <span class="text-white">Save</span>
                            </button>

                            <button type="button" class="btn" id="copySeed">
                                <img src="{{ asset('assets/images/quantumography/copy.svg') }}" style="width: 20px;">  <span class="text-white">Copy</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <input type="hidden" id="seedInput" name="seed" value="{{ $seed }}">
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const seedInput = document.getElementById('seedInput');
        const seedTagsContainer = document.getElementById('seedTagsContainer');
        const newSeedInput = document.getElementById('newSeedInput');
        const copySeedButton = document.getElementById('copySeed');
        const downloadSeedButton = document.getElementById('downloadSeed');

        // Function to update the hidden seed input
        const updateSeedInput = () => {
            const tags = Array.from(seedTagsContainer.querySelectorAll('.tag')).map(tag =>
                tag.textContent.trim().replace(/\s×$/, '') // Remove the close icon text
            );
            seedInput.value = tags.join(' ');
        };

        // Function to toggle the visibility of the input based on the number of tags
        const toggleInputVisibility = () => {
            const tagsCount = seedTagsContainer.querySelectorAll('.tag').length;
            newSeedInput.style.display = tagsCount < 16 ? 'block' : 'none';
        };

        // Add new seed word as a tag when pressing Space
        newSeedInput.addEventListener('keypress', (event) => {
            if (event.key === ' ') { // Check for the Space key
                event.preventDefault(); // Prevent the default space action
                const word = newSeedInput.value.trim();
                if (word !== '') {
                    if (seedTagsContainer.querySelectorAll('.tag').length < 16) {
                        const tag = document.createElement('span');
                        tag.classList.add('tag');
                        tag.textContent = word;

                        if (@json($removable)) {
                            const removeIcon = document.createElement('i');
                            removeIcon.classList.add('fas', 'fa-times', 'remove-tag');
                            tag.appendChild(removeIcon);
                        }

                        // Insert the new tag before the input field
                        seedTagsContainer.insertBefore(tag, newSeedInput);
                        updateSeedInput();
                        toggleInputVisibility();
                        newSeedInput.value = ''; // Clear the input
                    } else {
                        toastr.error('Maximum 16 seed words allowed.');
                    }
                }
            }
        });

        // Handle paste event to separate words and create tags
        newSeedInput.addEventListener('paste', (event) => {
            event.preventDefault(); // Prevent the default paste behavior
            const pastedText = event.clipboardData.getData('text'); // Get the pasted text
            const words = pastedText.split(/\s+/); // Split by spaces and newlines
            words.forEach((word) => {
                if (word.trim() !== '' && seedTagsContainer.querySelectorAll('.tag').length < 16) {
                    const tag = document.createElement('span');
                    tag.classList.add('tag');
                    tag.textContent = word;

                    if (@json($removable)) {
                        const removeIcon = document.createElement('i');
                        removeIcon.classList.add('fas', 'fa-times', 'remove-tag');
                        tag.appendChild(removeIcon);
                    }

                    // Insert the new tag before the input field
                    seedTagsContainer.insertBefore(tag, newSeedInput);
                }
            });
            updateSeedInput();
            toggleInputVisibility();
        });

        // Copy seed to clipboard
        copySeedButton?.addEventListener('click', () => {
            updateSeedInput();
            navigator.clipboard.writeText(seedInput.value).then(() => {
                toastr.success('Seed copied to clipboard!');
            }).catch(err => {
                toastr.error('Failed to copy seed.');
            });
        });

        // Download seed as a text file
        downloadSeedButton?.addEventListener('click', () => {
            updateSeedInput();
            const blob = new Blob([seedInput.value], {
                type: 'text/plain'
            });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'seed.txt';
            link.click();
            toastr.success('Seed downloaded successfully.');
        });

        // Remove a tag on clicking the close icon (if removable is enabled)
        seedTagsContainer.addEventListener('click', (event) => {
            if (event.target.classList.contains('remove-tag')) {
                const tagElement = event.target.parentElement;
                seedTagsContainer.removeChild(tagElement);
                updateSeedInput();
                toggleInputVisibility(); // Update input visibility after tag removal
            }
        });

        // Initial check to set input visibility based on the current number of tags
        toggleInputVisibility();
    });
</script>

<style>
    .tags-container {
        position: relative;
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
        padding: 8px;
        border-radius: 8px;
    }

    .tags-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 8px;
        background: linear-gradient(161.72deg, #002E59 31.7%, #0061BF 92.51%);
        z-index: -1;
    }

    .tag {
        background-color: #f0f0f0;
        border-radius: 20px;
        padding: 5px 10px;
        display: flex;
        align-items: center;
        font-size: 14px;
    }

    .tag .remove-tag {
        margin-left: 8px;
        cursor: pointer;
        color: #ff0000;
    }

</style>
