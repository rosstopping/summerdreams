(function(e){var t=(e,t)=>{let n=e.__vccOpts||e;for(let[e,r]of t)n[e]=r;return n},n={mounted(){console.log(`m ounted`)}};function r(t,n,r,i,a,o){let s=(0,e.resolveComponent)(`Head`),c=(0,e.resolveComponent)(`Heading`),l=(0,e.resolveComponent)(`Card`);return(0,e.openBlock)(),(0,e.createElementBlock)(`div`,null,[(0,e.createVNode)(s,{title:`Calendar`}),(0,e.createVNode)(c,{class:`mb-6`},{default:(0,e.withCtx)(()=>[...n[0]||=[(0,e.createTextVNode)(`Calendar`,-1)]]),_:1}),(0,e.createVNode)(l,{class:`p-6`},{default:(0,e.withCtx)(()=>[...n[1]||=[(0,e.createElementVNode)(`div`,{"x-data":`{
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
			}`},[(0,e.createElementVNode)(`div`,{"x-ref":`calendar`})],-1)]]),_:1})])}var i=t(n,[[`render`,r]]);Nova.booting((e,t)=>{Nova.inertia(`Calendar`,i)})})(Vue);