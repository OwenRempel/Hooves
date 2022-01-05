import { Link } from "react-router-dom"
function CompList() {
    return (
        <div>
            <h1>All Companies</h1>
            <Link to='add'><button className="btn">Add</button> </Link>
        </div>
    )
}

export default CompList
