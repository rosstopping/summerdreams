<x-layouts.app>
	@php
		$weeklySchedule = [
			['day' => 'Monday', 'event' => 'Sunset Yacht Party'],
			['day' => 'Tuesday', 'event' => 'Projekt Live'],
			['day' => 'Wednesday', 'event' => 'Paraiso presents Nova Mondo, Club Night'],
			['day' => 'Thursday', 'event' => 'Pambos Pool Party'],
			['day' => 'Friday', 'event' => 'Vice Parties'],
			['day' => 'Saturday', 'event' => 'Carnage Bar Crawl & Afterparty'],
			['day' => 'Sunday', 'event' => 'Sunset Sessions'],
		];

		$eventDetails = [
			[
				'day' => 'Monday',
				'title' => 'Sunset Yacht Party',
				'image' => '/images/events/vice-parties/IMG_5773.jpg',
				'meta' => [
					'Meeting Point: Pambos Napa Rocks Hotel',
					'Meet At: 15:00',
					'Sailing Time: 16:30 - 20:30',
				],
				'description' => 'The Sunset Yacht Party in Ayia Napa is a premium party experience combining great music, beautiful coastal views and an unforgettable sunset atmosphere. The yacht cruises the coast towards the Blue Lagoon with swim stops in crystal-clear waters. Onboard, guests enjoy free shots, special guest DJs and energetic hosts creating a vibrant party atmosphere as the sun sets over the Mediterranean.',
				'music' => 'RnB, HipHop, Afrohouse, Afrobeats, Amapiano, Bashment, Old School',
				'includes' => [
					'Afro-Caribbean buffet by Jerk n Jollof at the meeting point',
					'AC coach transfer to the pier and back',
					'Yacht cruise to the Blue Lagoon with swim stops',
					'Free shots onboard',
					'Weekly special guest DJs and hosts',
				],
			],
			[
				'day' => 'Tuesday',
				'title' => 'Projekt Live w/ Nathan Dawe',
				'image' => '/images/events/vice-parties/IMG_5774.jpg',
				'meta' => [
					'Entry: 21:30 - 01:00',
					'Venue: Pambos Napa Rocks',
				],
				'description' => 'Projekt Live presents Nathan Dawe. The chart-topping DJ and music producer brings his electrifying sound to Ayia Napa for an exclusive weekly summer residency.',
				'includes' => [
					'Festival production',
					'VIP tables and bottle service',
					'Live performers',
					'Free entrance into the official after party',
				],
			],
			[
				'day' => 'Wednesday',
				'title' => 'Paraiso Club Night',
				'image' => '/images/events/vice-parties/IMG_5775.jpg',
				'meta' => [
					'Entry: 01:00 - 05:00',
					'Venue: Shuffle Club',
				],
				'description' => 'House music, high energy and dedicated production with weekly special guest DJs in an intimate underground nightclub. Big vibes.',
			],
			[
				'day' => 'Thursday',
				'title' => 'Pambos Pool Party',
				'image' => '/images/events/pambos/IMG_5768.jpg',
				'meta' => [
					'Entry: 14:00 - 19:00',
					'Venue: Pambos Napa Rocks',
				],
				'description' => 'The spacious pool side of the Napa Rocks Hotel is home to the Pambos Pool Party. With revellers often in their thousands, this is one of the hottest pool parties in Napa.',
			],
			[
				'day' => 'Friday',
				'title' => 'Vice Parties On The Roof',
				'image' => '/images/events/vice-parties/IMG_5779.jpg',
				'meta' => [
					'Entry: 18:00 - 23:00',
					'Venue: Rio Gardens Hotel',
					'Dress Code: All Black',
				],
				'description' => 'Ayia Napa\'s most exclusive rooftop party is back for its 4th year in 2026. Featuring the island\'s hottest house music DJs, bespoke Vice Parties cocktails and unmatched vibes overlooking the Cyprus skyline. The signature all-black dress code sets this party out from the rest.',
				'music' => 'House Music',
			],
			[
				'day' => 'Saturday',
				'title' => 'Carnage Bar Crawl',
				'image' => '/images/events/vice-parties/IMG_3104.JPG',
				'meta' => [
					'Start Time: 20:30',
					'Meeting Point: Pambos Napa Rocks Hotel',
					'After Party: Aqua Club',
				],
				'description' => 'Carnage Bar Crawl takes you to the biggest and best venues all over town with crazy drinking games, free shots, discounted drinks and giveaways all night. It finishes at Ayia Napa\'s famous after party club, AQUA Club. With groups of up to 1000 partygoers and 12 hours of partying potential, be ready for a night of carnage.',
			],
			[
				'day' => 'Sunday',
				'title' => 'Sunset Sessions Pool Party',
				'image' => '/images/events/pambos/IMG_5772.jpg',
				'meta' => [
					'Entry: 16:00 - 22:00',
					'Venue: Fedrania Gardens Hotel',
				],
				'description' => 'Sunset Sessions turns 5. The best Sunday pool party is back for another year of unforgettable moments in 2026. Taking place at Fedrania Gardens Outdoor Arena, expect the island\'s hottest DJs, bespoke cocktails, entertainers and weekly special guests against a Cypriot sunset backdrop. Guests are greeted with a complimentary glass of champagne, and VIP swim-up beds or seated areas can be reserved with premium bottle service.',
			],
		];
	@endphp

	<div class="relative -mt-28 overflow-hidden pt-28 text-gray-950 sm:-mt-32 sm:pt-32">

		<section class="relative px-4 pb-10 sm:px-6 lg:px-8">
			<div class="mx-auto max-w-7xl overflow-hidden rounded-[2.5rem] border-4 border-black bg-white shadow-[10px_10px_0_0_#171717] sm:shadow-[14px_14px_0_0_#171717]">
				<div class="grid gap-0 lg:grid-cols-[1.1fr_0.9fr]">
					<div class="bg-[#111111] px-6 py-10 text-white sm:px-10 lg:px-12 lg:py-14">
						<p class="text-xs font-black uppercase tracking-[0.26em] text-[#7fe7ff]">Summer Dreams 2026</p>
						<h1 class="mt-4 font-heading text-[clamp(2.6rem,6.4vw,6rem)] font-black uppercase leading-[0.88] tracking-[-0.04em]">Package Event Details</h1>
						<p class="mt-6 max-w-2xl text-sm leading-7 text-white/80 sm:text-base">Everything included in your week is right here: all seven events, exact timings, venues and what is included, plus your two package options.</p>
					</div>

					<div class="relative min-h-[18rem] bg-[#ff6fa9] p-6 sm:p-8 lg:p-10">
						<div class="absolute -right-8 -top-8 h-28 w-28 rounded-full border-4 border-black bg-[#ffd54a]"></div>
						<div class="absolute bottom-6 left-6 h-4 w-28 rounded-full bg-black/20"></div>
						<div class="relative overflow-hidden rounded-[1.5rem] border-4 border-black bg-white shadow-[8px_8px_0_0_#171717]">
							<img src="/images/events/vice-parties/IMG_5776.jpg" alt="Summer Dreams party atmosphere" class="h-[18rem] w-full object-cover">
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="relative z-10 px-4 pb-16 pt-4 sm:px-6 sm:pt-6 lg:px-8">
			<div class="mx-auto max-w-7xl overflow-hidden rounded-[2.25rem] border-4 border-black bg-[#fff0be] shadow-[10px_10px_0_0_#171717]">
				<div class="border-b-4 border-black px-6 py-6 sm:px-8">
					<p class="text-xs font-black uppercase tracking-[0.24em] text-black/60">Summer Dreams Package</p>
					<h2 class="mt-2 font-heading text-[clamp(2rem,4.4vw,3.8rem)] font-black uppercase leading-[0.9] tracking-[-0.03em]">Weekly Schedule</h2>
				</div>
				<div class="grid gap-4 p-4 sm:grid-cols-2 sm:p-6 lg:grid-cols-3 xl:grid-cols-4">
					@foreach ($weeklySchedule as $slot)
						<div class="rounded-[1.35rem] border-4 border-black bg-white px-5 py-5 shadow-[6px_6px_0_0_#171717]">
							<p class="text-xs font-black uppercase tracking-[0.22em] text-black/50">{{ $slot['day'] }}</p>
							<p class="mt-2 text-base font-black uppercase leading-6">{{ $slot['event'] }}</p>
						</div>
					@endforeach
				</div>
			</div>
		</section>

		<section class="px-4 pb-20 sm:px-6 lg:px-8">
			<div class="mx-auto max-w-7xl space-y-8">
				@foreach ($eventDetails as $detail)
					<div class="overflow-hidden rounded-[2rem] border-4 border-black bg-white shadow-[10px_10px_0_0_#171717]">
						<div class="grid gap-0 lg:grid-cols-[0.95fr_1.05fr]">
							<div class="relative min-h-[17rem] lg:min-h-[24rem]">
								<img src="{{ $detail['image'] }}" alt="{{ $detail['title'] }}" class="absolute inset-0 h-full w-full object-cover">
								<div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-transparent"></div>
								<div class="absolute bottom-5 left-5 rounded-full border-2 border-white bg-black/45 px-4 py-2 text-xs font-black uppercase tracking-[0.2em] text-white backdrop-blur-sm">{{ $detail['day'] }}</div>
							</div>
							<div class="bg-[#111111] px-6 py-7 text-white sm:px-8 sm:py-8">
								<h3 class="font-heading text-[clamp(2rem,3.8vw,3.2rem)] font-black uppercase leading-[0.9] tracking-[-0.03em]">{{ $detail['title'] }}</h3>
								<ul class="mt-4 space-y-2 text-sm font-black uppercase tracking-[0.08em] text-[#7fe7ff] sm:text-[0.92rem]">
									@foreach ($detail['meta'] as $line)
										<li>{{ $line }}</li>
									@endforeach
								</ul>
								<p class="mt-5 text-sm leading-7 text-white/80 sm:text-base">{{ $detail['description'] }}</p>

								@if (!empty($detail['music']))
									<div class="mt-5 rounded-[1rem] border-2 border-white/70 bg-white/10 px-4 py-3 text-sm">
										<p class="text-xs font-black uppercase tracking-[0.2em] text-white/70">Music Policy</p>
										<p class="mt-2 font-medium text-white/90">{{ $detail['music'] }}</p>
									</div>
								@endif

								@if (!empty($detail['includes']))
									<div class="mt-5 rounded-[1rem] border-2 border-white/70 bg-white/10 px-4 py-4">
										<p class="text-xs font-black uppercase tracking-[0.2em] text-white/70">What's Included</p>
										<ul class="mt-3 space-y-2 text-sm leading-6 text-white/85">
											@foreach ($detail['includes'] as $included)
												<li>- {{ $included }}</li>
											@endforeach
										</ul>
									</div>
								@endif
							</div>
						</div>
					</div>
				@endforeach
			</div>
		</section>

		<section class="px-4 pb-20 sm:px-6 lg:px-8">
			<div class="mx-auto grid max-w-7xl gap-8 lg:grid-cols-2">
				<div class="rounded-[2rem] border-4 border-black bg-[#7fe7ff] p-7 shadow-[8px_8px_0_0_#171717] sm:p-8">
					<p class="text-xs font-black uppercase tracking-[0.24em] text-black/60">Napa Perks</p>
					<h3 class="mt-3 font-heading text-[clamp(1.9rem,3.7vw,3rem)] font-black uppercase leading-[0.92] tracking-[-0.03em]">Extra Value All Week</h3>
					<ul class="mt-6 space-y-3 text-sm font-black uppercase leading-6 sm:text-base">
						<li>- Discounts on quads and buggies</li>
						<li>- Discount at partnering restaurants</li>
						<li>- Discount on water sports</li>
						<li>- Discount at waterpark</li>
						<li>- Discounted or free entry at partnering clubs</li>
						<li>- Discounted drinks at partnering bars</li>
					</ul>
				</div>

				<div class="rounded-[2rem] border-4 border-black bg-[#ffd54a] p-7 shadow-[8px_8px_0_0_#171717] sm:p-8">
					<p class="text-xs font-black uppercase tracking-[0.24em] text-black/60">Package Tiers</p>
					<h3 class="mt-3 font-heading text-[clamp(1.9rem,3.7vw,3rem)] font-black uppercase leading-[0.92] tracking-[-0.03em]">Pick Your Level</h3>
					<div class="mt-6 space-y-4">
						<div class="rounded-[1.25rem] border-4 border-black bg-white px-5 py-5">
							<p class="text-xs font-black uppercase tracking-[0.2em] text-black/60">Fully Loaded Package</p>
							<p class="mt-2 text-lg font-black uppercase">Includes every event and Napa perks</p>
							<p class="mt-3 text-3xl font-black">&pound;150</p>
						</div>
						<div class="rounded-[1.25rem] border-4 border-black bg-white px-5 py-5">
							<p class="text-xs font-black uppercase tracking-[0.2em] text-black/60">Napa Essentials</p>
							<p class="mt-2 text-lg font-black uppercase">Includes Paraiso, Pambos, Vice and Sunset Sessions</p>
							<p class="mt-3 text-3xl font-black">&pound;125</p>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="px-4 pb-20 sm:px-6 lg:px-8">
			<div class="mx-auto max-w-7xl overflow-hidden rounded-[2.25rem] border-4 border-black bg-[#111111] px-6 py-10 text-white shadow-[10px_10px_0_0_#171717] sm:px-10 lg:px-12 lg:py-12">
				<div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
					<div class="max-w-3xl">
						<p class="text-xs font-black uppercase tracking-[0.28em] text-[#7fe7ff]">Book With Flexibility</p>
						<h2 class="mt-3 font-heading text-[clamp(2rem,4vw,3.4rem)] font-black uppercase leading-[0.94] tracking-[-0.04em]">Book today with only &pound;20 deposit.</h2>
					</div>
					<div class="flex flex-col gap-4 sm:flex-row">
						<a href="/book" class="inline-flex items-center justify-center rounded-full border-2 border-black bg-[#ffd54a] px-6 py-3 text-sm font-black uppercase tracking-[0.18em] text-black transition-transform duration-200 hover:-translate-y-1">Book The Package</a>
						<a href="/contact" class="inline-flex items-center justify-center rounded-full border-2 border-white bg-transparent px-6 py-3 text-sm font-black uppercase tracking-[0.18em] text-white transition-transform duration-200 hover:-translate-y-1">Ask A Question</a>
					</div>
				</div>
			</div>
		</section>
	</div>
</x-layouts.app>
