import Link from "next/link"
function index() {
    return (
        <div className="container">
            <Link href='/companies/add'><button className="btn">Add Company</button></Link>
        </div>
    )
}

export default index
