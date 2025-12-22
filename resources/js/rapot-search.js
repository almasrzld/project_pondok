window.rapotSearch = function () {
    return {
        search: "",
        semester_id: "",

        init() {
            // optional
        },

        fetchData() {
            const params = new URLSearchParams({
                search: this.search,
                semester_id: this.semester_id,
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
                    const table = doc.querySelector("#rapot-table");

                    if (table) {
                        document.querySelector("#rapot-table").innerHTML =
                            table.innerHTML;
                    }
                });
        },
    };
};
