<template>
    <div>

        <Head title="Calendar" />
        <Heading class="mb-6">Calendar</Heading>
        <Card class="p-6">
            <div x-data="{
				init() {
					console.log('init');
						const events = Nova.config('events');
						this.calendar = new FullCalendar.Calendar(this.$refs.calendar, {
								events: (info, success) => success(events),
								initialView: 'dayGridMonth',
								selectable: true,
								unselectAuto: false,
								editable: false,
								firstDay: 1,
								eventClick: function(info) {
									info.jsEvent.preventDefault(); // don't let the browser navigate

									if (info.event.url) {
										window.open(info.event.url);
									}
								}
						})

						this.calendar.render()
				},
				getEventIndex(info) {
						return this.events.findIndex((event) => event.id == info.event.id)
				},
			}">
                <div x-ref="calendar"></div>
            </div>
        </Card>
    </div>
</template>
<script>
export default {
    mounted() {
        console.log('m ounted');
    },
}

</script>
<style>
/* Scoped Styles */

</style>
