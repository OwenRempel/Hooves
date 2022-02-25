import { Link } from "react-router-dom"

function AllSettings() {
    return (
        <div>
            <h1>All settings</h1>
            <Link to='/settings/pens'>Pens</Link>
        </div>
    )
}

export default AllSettings
