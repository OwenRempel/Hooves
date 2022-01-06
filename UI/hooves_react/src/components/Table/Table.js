import TableBody from "./TableBody"
import TableHead from "./TableHead"
import '../../css/Table.css'

function Table({ table }) {
    return (
        <div className="tableCatch">
            <table className="BuildTable highlight">
                <TableHead Head={table.Info}/>
                <TableBody Body={table.Data}/>
            </table>
        </div>
        
    )
}

export default Table
