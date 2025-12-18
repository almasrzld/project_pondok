window.santriSearch = function () {
    return {
        search: "",
        status: "",

        init() {
            // optional init
        },

        fetchData() {
            const params = new URLSearchParams({
                search: this.search,
                status: this.status,
            });

            fetch(`${window.location.pathname}?${params.toString()}`, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            })
                .then((res) => res.text())
                .then((html) => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, "text/html");
                    const table = doc.querySelector("#santri-table");

                    if (table) {
                        document.querySelector("#santri-table").innerHTML =
                            table.innerHTML;
                    }
                });
        },
    };
};
