import { Link } from "react-router-dom"

function AllSettings() {
    return (
        <>
            <h1>All settings</h1>
            <Link to='/settings/pens' className="btn">Pens</Link>
        </>
    )
}

export default AllSettings
