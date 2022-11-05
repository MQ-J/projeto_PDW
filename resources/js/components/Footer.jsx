export function Footer() {
    return (
        <div className="d-flex justify-content-around border border-dark rounded fixed-bottom m-3 bg-cadet">
            <div className="d-flex flex-column justify-content-center w-25">
                <a className="btn p-0" href="resources/js/components/Footer" role="button">
                    <p className="text-center text-nowrap mb-0">Bootstrap 5</p>
                </a>
            </div>

            <div className="d-flex flex-column justify-content-center w-25">
                <a className="btn p-0" href="resources/js/components/Footer" role="button">
                    <p className="text-center mb-0">React</p>
                </a>
            </div>
        </div>
    )
}
