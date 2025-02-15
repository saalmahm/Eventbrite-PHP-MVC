const searchButton = document.getElementById('searchButton');
const eventSearch = document.getElementById('eventSearch');
const locationSearch = document.getElementById('locationSearch');
const eventsContainer = document.getElementById('eventsContainer');


function handleEventClick(eventId) {
    window.location.href = 'evenement/details/' + eventId;

}

function toggleFilters() {
        const filtersSection = document.getElementById('filters-section');
        filtersSection.classList.toggle('hidden');
        
        if (!filtersSection.classList.contains('hidden')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = 'auto';
        }
    }

    window.addEventListener('resize', function() {
        const filtersSection = document.getElementById('filters-section');
        if (window.innerWidth >= 768) {
            filtersSection.classList.remove('hidden');
            document.body.style.overflow = 'auto';
        } else {
            filtersSection.classList.add('hidden');
        }
});


   

    searchButton.addEventListener('click', function() {
        const eventSearchValue = eventSearch.value.toLowerCase();
        const locationSearchValue = locationSearch.value.toLowerCase();

        const events = eventsContainer.querySelectorAll('.bg-white');

        events.forEach(function(event) {
            const eventTitle = event.querySelector('h3').innerText.toLowerCase();
            const eventLocation = event.querySelector('.text-sm').innerText.toLowerCase();

            const titleMatch = eventTitle.includes(eventSearchValue);
            const locationMatch = eventLocation.includes(locationSearchValue);

            if (titleMatch && locationMatch) {
                event.style.display = 'block';
            } else {
                event.style.display = 'none'; 
            }
        });
    });

    const sortSelect = document.getElementById('sortSelect');

function sortEvents() {
    const selectedOption = sortSelect.value;
    const eventsContainer = document.getElementById('eventsContainer');
    const events = Array.from(eventsContainer.querySelectorAll('.bg-white'));

    events.sort((a, b) => {
        const priceA = parseFloat(a.querySelector('.text-xl').innerText.replace('MAD', '').trim());
        const priceB = parseFloat(b.querySelector('.text-xl').innerText.replace('MAD', '').trim());

        const dateA = a.querySelector('#dateEvent').innerText.trim();
        const dateB = b.querySelector('#dateEvent').innerText.trim();

        const dateObjA = new Date(dateA);
        const dateObjB = new Date(dateB);

        switch (selectedOption) {
            case 'priceAsc':
                return priceA - priceB;
            case 'priceDesc':
                return priceB - priceA;
            case 'dateAsc':
                return dateObjB - dateObjA;
            default:
                return 0;
        }
    });

    eventsContainer.innerHTML = '';
    events.forEach(event => eventsContainer.appendChild(event));
}

sortSelect.addEventListener('change', sortEvents);

sortEvents();




