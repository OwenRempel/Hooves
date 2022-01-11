function TableHead({ Head }) {

    return (
        <thead>
            <tr>
                <th></th>
                {
                Object.keys(Head).map((key, i) => (
                    <th key={i}>{Head[key]}</th>
                    
                ))
                }
            </tr>
        </thead>
    )
}

export default TableHead
